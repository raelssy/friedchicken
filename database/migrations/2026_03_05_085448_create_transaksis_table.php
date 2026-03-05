<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        

       Schema::create('transaksis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('cabang_id')->constrained('cabangs'); 
    $table->date('tanggal');
    $table->integer('total');
    $table->timestamps();
});
    }


    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }

};