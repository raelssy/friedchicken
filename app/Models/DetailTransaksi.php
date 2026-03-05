<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    // Tambahkan ini agar Laravel tidak mencari tabel 'detail_transaksis'
    protected $table = 'detail_transaksi'; 

    protected $fillable = [
        'transaksi_id',
        'menu_id',
        'qty', // Anda menggunakan 'qty', bukan 'jumlah'
        'harga',
        'subtotal'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    // Tambahkan relasi balik ke Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}