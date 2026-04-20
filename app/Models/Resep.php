<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $fillable = [
        'menu_id',
        'bahan_id',
        'jumlah'
    ];

    public function bahan()
    {
        return $this->belongsTo(\App\Models\Bahan::class);
    }

    public function menu()
    {
        return $this->belongsTo(\App\Models\Menu::class);
    }
}
