<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $fillable = [
        'cabang_id',
        'nama_bahan',
        'jumlah',
        'satuan'
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}