<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Kolom baru pada tabel barang
        Schema::table('barang', function (Blueprint $table) {
            $table->boolean('is_tukar_wadah')->default(false)->after('stok_awal');
            $table->integer('stok_kosong')->default(0)->after('is_tukar_wadah');
            $table->integer('harga_wadah')->default(0)->after('stok_kosong');
        });

        // 2. Kolom penanda status tukar wadah pada rincian transaksi
        Schema::table('transaksi_detail', function (Blueprint $table) {
            $table->boolean('tukar_wadah')->default(true)->after('subtotal');
        });
    }

    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn(['is_tukar_wadah', 'stok_kosong', 'harga_wadah']);
        });

        Schema::table('transaksi_detail', function (Blueprint $table) {
            $table->dropColumn('tukar_wadah');
        });
    }
};
