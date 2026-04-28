<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Transaksi::with(['menu','cabang'])
            ->where('status','success')
            ->get()
            ->map(function ($t) {
                return [
                    $t->tanggal,
                    $t->cabang->nama_cabang ?? '-',
                    $t->menu->nama_menu ?? '-',
                    $t->qty,
                    strtoupper($t->metode_pembayaran),
                    $t->total,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Cabang',
            'Menu',
            'Qty',
            'Metode',
            'Total (Rp)',
        ];
    }
}

?>