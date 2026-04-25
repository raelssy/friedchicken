<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class DokuController extends Controller
{
    public function callback(Request $request)
    {
        $data = $request->all();

        // 🔥 LOG (WAJIB untuk debug awal)
        file_put_contents(
            storage_path('logs/doku.log'),
            json_encode($data) . PHP_EOL,
            FILE_APPEND
        );

        // =========================
        // AMBIL DATA DOKU
        // =========================
        $invoice = $data['order']['invoice_number'] ?? null;
        $status  = $data['transaction']['status'] ?? null;

        // =========================
        // VALIDASI
        // =========================
        if (!$invoice) {
            return response()->json(['message' => 'no invoice']);
        }

        // =========================
        // CEK STATUS PEMBAYARAN
        // =========================
        if ($status != 'SUCCESS') {
            return response()->json(['message' => 'not success']);
        }

        DB::beginTransaction();

        try {

            // 🔥 AMBIL TRANSAKSI BERDASARKAN INVOICE
            $transaksis = Transaksi::where('invoice', $invoice)
                ->where('status', 'pending')
                ->get();

            if ($transaksis->isEmpty()) {
                return response()->json(['message' => 'already processed']);
            }

            foreach ($transaksis as $trx) {

                $menu = Menu::find($trx->menu_id);

                if (!$menu) continue;

                // =========================
                // KURANGI STOK
                // =========================
                if ($menu->stok >= $trx->qty) {
                    $menu->decrement('stok', $trx->qty);
                }

                // =========================
                // UPDATE STATUS
                // =========================
                $trx->update([
                    'status' => 'success'
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'success']);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}