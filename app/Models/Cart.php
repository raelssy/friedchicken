<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'menu_id',
        'qty'
    ];

    // Relasi ke Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}