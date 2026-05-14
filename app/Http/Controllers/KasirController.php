<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Cabang;
use App\Models\Menu;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class KasirController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Transaksi::with('menu')->latest();
        
        if ($user->role != 'admin') {
            $query->where('cabang_id', $user->cabang_id);
        }

        $transaksi = $query->get();
        return view('kasir.index', compact('transaksi'));
    }

    public function create()
    {
        $user = Auth::user();
        
        if ($user->role == 'admin') {
            $menu = Menu::all();
        } else {
            $menu = Menu::where('cabang_id', $user->cabang_id)->get();
        }

        $cabang = Cabang::all();
        $cart = Cart::with('menu')->where('user_id', Auth::id())->get();
        $totalCart = $cart->sum(fn($i) => ($i->menu->harga ?? 0) * $i->qty);

        return view('kasir.create', compact('menu', 'cabang', 'cart', 'totalCart'));
    }

    public function store(Request $request)
{
    $request->validate([
        'menu_id' => 'required|exists:menu,id',
        'qty' => 'required|integer|min:1',
    ]);

    $user = Auth::user();
    $menu = Menu::findOrFail($request->menu_id);

    // 🔥 Cek Stok
    if ($menu->stok < $request->qty) {
        return back()->with('error', 'Gagal! Stok ' . $menu->nama_menu . ' tidak mencukupi.');
    }

    $cart = Cart::where('user_id', $user->id)
                ->where('menu_id', $request->menu_id)
                ->first();

    if ($cart) {
        // Cek jika total di keranjang melebihi stok
        if (($cart->qty + $request->qty) > $menu->stok) {
            return back()->with('error', 'Gagal! Total di keranjang melebihi stok tersedia.');
        }
        $cart->increment('qty', $request->qty);
    } else {
        Cart::create([
            'user_id'   => $user->id,
            'menu_id'   => $request->menu_id,
            'qty'       => $request->qty,
            'cabang_id' => $menu->cabang_id 
        ]);
    }

    // Return tanpa pesan success agar tidak muncul pop-up, sesuai permintaan Anda sebelumnya
    return back();
}





    public function addToCart($id)
    {
        $user = Auth::user();
        $menu = Menu::findOrFail($id);

        if ($menu->stok <= 0) {
            return back()->with('error', 'Gagal! Stok untuk ' . $menu->nama_menu . ' sudah habis.');
        }

        $cart = Cart::where('user_id', $user->id)->where('menu_id', $id)->first();

        if ($cart) {
            if ($cart->qty >= $menu->stok) {
                return back()->with('error', 'Gagal! Jumlah di keranjang sudah maksimal sesuai stok.');
            }
            $cart->increment('qty');
        } else {
            Cart::create([
                'user_id'   => $user->id,
                'menu_id'   => $id,
                'qty'       => 1,
                'cabang_id' => $menu->cabang_id 
            ]);
        }

        return back(); // Notifikasi success dihapus
    }

    public function removeCart($id)
    {
        Cart::where('id', $id)->where('user_id', Auth::id())->delete();
        return back(); // Notifikasi success dihapus
    }

    public function checkout(Request $request)
    {
        $request->validate(['metode_pembayaran' => 'required|in:cash,qris']);
        $user_id = Auth::id();
        $cartItems = Cart::with('menu')->where('user_id', $user_id)->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        $cartItems = $cartItems->filter(fn($item) => $item->menu !== null);
        $total = $cartItems->sum(fn($i) => ($i->menu->harga ?? 0) * $i->qty);

        if ($request->metode_pembayaran == 'cash') {
            DB::beginTransaction();
            try {
                $invoice = 'INV-' . time();
                foreach ($cartItems as $item) {
                    $menu = $item->menu;
                    if ($menu->stok < $item->qty) {
                        throw new \Exception('Stok menu "' . $menu->nama_menu . '" tidak mencukupi.');
                    }
                    $menu->decrement('stok', $item->qty);
                    Transaksi::create([
                        'invoice'           => $invoice,
                        'menu_id'           => $menu->id,
                        'cabang_id'         => $menu->cabang_id,
                        'qty'               => $item->qty,
                        'total'             => $menu->harga * $item->qty,
                        'tanggal'           => now(),
                        'metode_pembayaran' => 'cash',
                        'status'            => 'success'
                    ]);
                }
                Cart::where('user_id', $user_id)->delete();
                DB::commit();
                return redirect()->route('kasir.create')->with('success', 'Transaksi Cash Berhasil!');
            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('error', $e->getMessage());
            }
        }

        if ($request->metode_pembayaran == 'qris') {
            DB::beginTransaction();
            try {
                $invoice = 'INV-' . time();
                foreach ($cartItems as $item) {
                    Transaksi::create([
                        'invoice'           => $invoice,
                        'menu_id'           => $item->menu_id,
                        'cabang_id'         => $item->menu->cabang_id,
                        'qty'               => $item->qty,
                        'total'             => $item->menu->harga * $item->qty,
                        'tanggal'           => now(),
                        'metode_pembayaran' => 'qris',
                        'status'            => 'pending'
                    ]);
                }
                Cart::where('user_id', $user_id)->delete(); // 🔥 KOSONGKAN KERANJANG SETELAH CHECKOUT QRIS
                DB::commit();
                
                // Integrasi DOKU tetap dipertahankan
                $clientId = config('services.doku.client_id');
                $secretKey = config('services.doku.secret_key');
                $baseUrl = config('services.doku.base_url');
                $timestamp = gmdate('Y-m-d\TH:i:s\Z');
                $requestId = uniqid();
                $user = Auth::user();
                $body = [
                    "order" => [
                        "invoice_number" => $invoice, 
                        "amount" => (int) $total,
                        "callback_url" => url('/kasir')
                    ],
                    "payment" => ["payment_due_date" => 60],
                    "customer" => ["name" => $user->name, "email" => $user->email]
                ];
                $jsonBody = json_encode($body);
                $digest = base64_encode(hash('sha256', $jsonBody, true));
                $requestTarget = '/checkout/v1/payment';
                $signature = base64_encode(hash_hmac('sha256', "Client-Id:$clientId\nRequest-Id:$requestId\nRequest-Timestamp:$timestamp\nRequest-Target:$requestTarget\nDigest:$digest", $secretKey, true));

                $response = Http::withHeaders([
                    'Client-Id' => $clientId, 'Request-Id' => $requestId, 'Request-Timestamp' => $timestamp,
                    'Signature' => "HMACSHA256=$signature", 'Digest' => $digest, 'Content-Type' => 'application/json'
                ])->post($baseUrl . $requestTarget, $body);

                if ($response->failed()) return back()->with('error', 'Doku Error: ' . $response->body());
                return redirect($response['response']['payment']['url']);
            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('error', 'QRIS Error: ' . $e->getMessage());
            }
        }
    }
}