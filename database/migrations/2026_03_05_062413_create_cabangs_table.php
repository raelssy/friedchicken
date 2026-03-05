<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    // Cek dulu apakah kolom cabang_id sudah ada
    if (!Schema::hasColumn('menu', 'cabang_id')) {
        Schema::table('menu', function (Blueprint $table) {
            $table->bigInteger('cabang_id')->unsigned()->after('id');
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabang');
    }
};
