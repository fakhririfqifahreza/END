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
    Schema::table('barang', function (Blueprint $table) {
        $table->string('stok_awal')->nullable()->after('stok_barang');
    });

    // Isi stok_awal barang yang sudah ada saat ini dengan nilai stok_barang
    DB::statement("UPDATE barang SET stok_awal = stok_barang WHERE stok_awal IS NULL");
}

public function down(): void
{
    Schema::table('barang', function (Blueprint $table) {
        $table->dropColumn('stok_awal');
    });
}
};
