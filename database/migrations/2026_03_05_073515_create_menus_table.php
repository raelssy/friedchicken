<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('nama_menu');
            $table->integer('harga');
            $table->string('kategori')->nullable();

            // 🔥 WAJIB untuk multi cabang
            $table->foreignId('cabang_id')
                  ->constrained('cabangs')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu'); // ✅ FIX
    }
};