<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'cabang_id',
        'tanggal',
        'total'
    ];

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}