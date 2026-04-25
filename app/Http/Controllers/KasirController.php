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
        $transaksi = Transaksi::with('menu')->latest()->get();
        return view('kasir.index', compact('transaksi'));
    }

    public function create()
    {
        $menu = Menu::where('stok', '>', 0)->get();
        $cabang = Cabang::all();

        $cart = Cart::with('menu')
            ->where('user_id', Auth::id())
            ->get();

        $totalCart = $cart->sum(fn($i) => $i->menu->harga * $i->qty);

        return view('kasir.create', compact('menu', 'cabang', 'cart', 'totalCart'));
    }

    public function addToCart($id)
    {
        $user_id = Auth::id();

        $cart = Cart::where('user_id', $user_id)
                    ->where('menu_id', $id)
                    ->first();

        if ($cart) {
            $cart->increment('qty');
        } else {
            Cart::create([
                'user_id' => $user_id,
                'menu_id' => $id,
                'qty' => 1
            ]);
        }

        return back();
    }

    public function removeCart($id)
    {
        Cart::where('id', $id)->delete();
        return back();
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:cash,qris'
        ]);

        $user_id = Auth::id();

        $cartItems = Cart::with('menu')
            ->where('user_id', $user_id)
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        $total = $cartItems->sum(fn($i) => $i->menu->harga * $i->qty);

        // =========================
        // CASH (LANGSUNG)
        // =========================
        if ($request->metode_pembayaran == 'cash') {

            DB::beginTransaction();

            try {
                foreach ($cartItems as $item) {
                    $menu = $item->menu;

                    if ($menu->stok < $item->qty) {
                        return back()->with('error', 'Stok tidak cukup');
                    }

                    $menu->decrement('stok', $item->qty);

                    Transaksi::create([
                        'invoice'  => 'INV-' . time(),
                        'menu_id'  => $menu->id,
                        'cabang_id'=> $menu->cabang_id,
                        'qty'      => $item->qty,
                        'total'    => $menu->harga * $item->qty,
                        'tanggal'  => now(),
                        'metode_pembayaran' => 'cash',
                        'status'   => 'success'
                    ]);
                }

                Cart::where('user_id', $user_id)->delete();

                DB::commit();

                return redirect()->route('kasir.index')->with('success', 'Cash berhasil');

            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('error', $e->getMessage());
            }
        }

        // =========================
        // 🔥 QRIS DOKU (PENDING)
        // =========================
        if ($request->metode_pembayaran == 'qris') {

            DB::beginTransaction();

            try {

                $invoice = 'INV-' . time();

                // 🔥 SIMPAN TRANSAKSI PENDING
                foreach ($cartItems as $item) {
                    Transaksi::create([
                        'invoice'  => $invoice,
                        'menu_id'  => $item->menu_id,
                        'cabang_id'=> $item->menu->cabang_id,
                        'qty'      => $item->qty,
                        'total'    => $item->menu->harga * $item->qty,
                        'tanggal'  => now(),
                        'metode_pembayaran' => 'qris',
                        'status'   => 'pending'
                    ]);
                }

                DB::commit();

                // =========================
                // KIRIM KE DOKU
                // =========================
                $clientId = config('services.doku.client_id');
                $secretKey = config('services.doku.secret_key');
                $baseUrl = config('services.doku.base_url');

                $timestamp = gmdate('Y-m-d\TH:i:s\Z');
                $requestId = uniqid();

                $user = Auth::user();

                $body = [
                    "order" => [
                        "invoice_number" => $invoice,
                        "amount" => (int) $total
                    ],
                    "payment" => [
                        "payment_due_date" => 60
                    ],
                    "customer" => [
                        "name" => $user->name,
                        "email" => $user->email
                    ]
                ];

                $jsonBody = json_encode($body);
                $digest = base64_encode(hash('sha256', $jsonBody, true));
                $requestTarget = '/checkout/v1/payment';

                $signature = base64_encode(hash_hmac(
                    'sha256',
                    "Client-Id:$clientId\nRequest-Id:$requestId\nRequest-Timestamp:$timestamp\nRequest-Target:$requestTarget\nDigest:$digest",
                    $secretKey,
                    true
                ));

                $response = Http::withHeaders([
                    'Client-Id' => $clientId,
                    'Request-Id' => $requestId,
                    'Request-Timestamp' => $timestamp,
                    'Signature' => "HMACSHA256=$signature",
                    'Digest' => $digest,
                    'Content-Type' => 'application/json'
                ])->post($baseUrl . $requestTarget, $body);

                if ($response->failed()) {
                    return back()->with('error', $response->body());
                }

                $paymentUrl = $response['response']['payment']['url'];

                return redirect($paymentUrl);

            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('error', $e->getMessage());
            }
        }
    }
}