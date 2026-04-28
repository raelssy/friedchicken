<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Cabang;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $cabangs = Cabang::all();

        // =========================
        // 🔥 BASE QUERY (SUCCESS ONLY)
        // =========================
        $query = Transaksi::where('status', 'success');

        // =========================
        // 🔥 FILTER CABANG
        // =========================
        if ($request->cabang_id) {
            $query->where('cabang_id', $request->cabang_id);
        }

        // =========================
        // 🔥 FILTER METODE
        // =========================
        if ($request->metode) {
            $query->where('metode_pembayaran', $request->metode);
        }

        // =========================
        // 🔥 FILTER TANGGAL
        // =========================
        if ($request->dari && $request->sampai) {
            $query->whereBetween('tanggal', [$request->dari, $request->sampai]);
        }

        // =========================
        // 🔥 DATA TRANSAKSI (DETAIL)
        // =========================
        $transaksis = (clone $query)
            ->with(['menu', 'cabang'])
            ->latest()
            ->get();

        // =========================
        // 🔥 TOTAL & JUMLAH
        // =========================
        $total = (clone $query)->sum('total');
        $jumlah = (clone $query)->count();

        // =========================
        // 🔥 TOTAL PER METODE (FIX: IKUT FILTER)
        // =========================
        $totalPerMetode = (clone $query)
            ->select('metode_pembayaran', DB::raw('SUM(total) as total'))
            ->groupBy('metode_pembayaran')
            ->get();

        // =========================
        // 🔥 LAPORAN PER HARI
        // =========================
        $perHari = (clone $query)
            ->select(
                DB::raw('DATE(tanggal) as tanggal'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // =========================
        // 🔥 GROUPING PER CABANG (NEW)
        // =========================
        $perCabang = (clone $query)
            ->select(
                'cabang_id',
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->with('cabang')
            ->groupBy('cabang_id')
            ->get();

        // =========================
        // 🔥 RETURN VIEW
        // =========================
        return view('laporan.index', compact(
            'transaksis',
            'total',
            'jumlah',
            'cabangs',
            'perHari',
            'totalPerMetode',
            'perCabang'
        ));
    }

    public function exportPdf(Request $request)
    {
        $data = Transaksi::with(['menu','cabang'])
            ->where('status','success')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf', compact('data'));

        return $pdf->download('laporan.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new LaporanExport, 'laporan.xlsx');
    }
}