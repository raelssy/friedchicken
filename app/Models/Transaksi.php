<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis'; // Memastikan Laravel memakai tabel yang ada 's' nya

    protected $fillable = [
        'cabang_id',
        'menu_id',
        'qty',
        'tanggal',
        'total',
        'invoice',
        'metode_pembayaran',
        'status'
    ];

 
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}