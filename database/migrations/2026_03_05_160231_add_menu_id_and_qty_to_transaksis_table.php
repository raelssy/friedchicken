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
    Schema::table('transaksis', function (Blueprint $table) {
        // Tambahkan kolom yang hilang
        $table->foreignId('menu_id')->after('cabang_id')->constrained('menu'); 
        $table->integer('qty')->after('menu_id');
    });
}

public function down(): void
{
    Schema::table('transaksis', function (Blueprint $table) {
        $table->dropForeign(['menu_id']);
        $table->dropColumn(['menu_id', 'qty']);
    });
}
};
