<?php

namespace App\Http\Controllers;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Cabang;
use App\Models\Menu;
use App\Models\Bahan;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class KasirController extends Controller
{
    // =========================
    // LIST TRANSAKSI
    // =========================
    public function index()
    {
        $transaksi = Transaksi::with('menu')->latest()->get();
        return view('kasir.index', compact('transaksi'));
    }

    // =========================
    // FORM TRANSAKSI
    // =========================
    public function create()
    {
        $menu = Menu::where('stok', '>', 0)->get();
        $cabang = Cabang::all();

        $cart = Cart::with('menu')
            ->where('user_id', Auth::id())
            ->get();

        $totalCart = $cart->sum(function ($item) {
            return $item->menu->harga * $item->qty;
        });

        return view('kasir.create', compact('menu', 'cabang', 'cart', 'totalCart'));
    }

    // =========================
    // SIMPAN TRANSAKSI MANUAL
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required|exists:cabangs,id',
            'menu_id'   => 'required|exists:menu,id',
            'qty'       => 'required|numeric|min:1',
            'total'     => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            $menu = Menu::findOrFail($request->menu_id);

            if ($menu->stok < $request->qty) {
                return back()->with('error', 'Stok tidak mencukupi!');
            }

            Transaksi::create([
                'menu_id'   => $request->menu_id,
                'cabang_id' => $request->cabang_id,
                'qty'       => $request->qty,
                'total'     => $request->total,
                'tanggal'   => now()->toDateString(),
                'metode_pembayaran' => 'cash'
            ]);

            $menu->decrement('stok', $request->qty);

            DB::commit();

            return redirect()->route('kasir.index')
                ->with('success', 'Transaksi berhasil');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $menu = Menu::all();
        $cabang = Cabang::all();

        return view('kasir.edit', compact('transaksi', 'menu', 'cabang'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'menu_id' => 'required|exists:menu,id',
            'qty'     => 'required|numeric|min:1',
            'total'   => 'required|numeric'
        ]);

        DB::beginTransaction();

        try {
            $transaksi = Transaksi::findOrFail($id);

            $menuLama = Menu::findOrFail($transaksi->menu_id);
            $menuBaru = Menu::findOrFail($request->menu_id);

            $menuLama->increment('stok', $transaksi->qty);

            if ($menuBaru->stok < $request->qty) {
                return back()->with('error', 'Stok tidak cukup!');
            }

            $menuBaru->decrement('stok', $request->qty);

            $transaksi->update([
                'menu_id' => $request->menu_id,
                'qty'     => $request->qty,
                'total'   => $request->total
            ]);

            DB::commit();

            return redirect()->route('kasir.index')
                ->with('success', 'Update berhasil');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    // =========================
    // CART
    // =========================
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

    // =========================
    // CHECKOUT (CASH + MIDTRANS)
    // =========================
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

        // 🔥 MIDTRANS QRIS
        if ($request->metode_pembayaran == 'qris') {

            MidtransConfig::$serverKey = config('services.midtrans.server_key');
            MidtransConfig::$isProduction = false;
            MidtransConfig::$isSanitized = true;
            MidtransConfig::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => 'INV-' . time(),
                    'gross_amount' => $total,
                ],
                'enabled_payments' => ['gopay', 'qris']
            ];

            $snapToken = Snap::getSnapToken($params);

            return view('kasir.payment', compact('snapToken'));
        }

        // 🔥 CASH
        DB::beginTransaction();

        try {
            foreach ($cartItems as $item) {
                $menu = $item->menu;

                if ($menu->stok < $item->qty) {
                    return back()->with('error', 'Stok tidak cukup');
                }

                $menu->decrement('stok', $item->qty);

                Transaksi::create([
                    'menu_id'   => $menu->id,
                    'cabang_id' => $menu->cabang_id,
                    'qty'       => $item->qty,
                    'total'     => $menu->harga * $item->qty,
                    'tanggal'   => now()->toDateString(),
                    'metode_pembayaran' => 'cash'
                ]);
            }

            Cart::where('user_id', $user_id)->delete();

            DB::commit();

            return redirect()->route('kasir.index')
                ->with('success', 'Checkout Cash berhasil');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }
}