<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    protected $fillable = [
        'nama_menu',
        'harga',
        'kategori',
        'stok',
        'cabang_id',
        'gambar' 
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'menu_id');
    }

    
}