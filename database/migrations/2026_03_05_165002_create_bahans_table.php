<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bahans', function (Blueprint $table) {
            $table->id();
            // Nama bahan mentah (contoh: Ayam Paha Mentah, Tepung, Minyak)
            $table->string('nama_bahan'); 
            
            // Jumlah stok bahan (menggunakan integer atau decimal jika ada koma)
            $table->integer('jumlah')->default(0); 
            
            // Satuan bahan (contoh: Kg, Gram, Liter, Pcs)
            $table->string('satuan'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahans');
    }
};