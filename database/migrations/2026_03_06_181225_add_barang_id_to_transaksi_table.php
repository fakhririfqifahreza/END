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
        Schema::table('transaksi', function (Blueprint $table) {
            // Tambahkan kolom barang_id sebagai foreign key (nullable agar tidak error untuk data lama)
            $table->unsignedBigInteger('barang_id')->nullable()->after('user_id');
            
            // Tambahkan foreign key constraint ke tabel barang
            $table->foreign('barang_id')
                  ->references('id_barang')
                  ->on('barang')
                  ->onDelete('set null'); // Jika barang dihapus, set NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['barang_id']);
            
            // Hapus kolom barang_id
            $table->dropColumn('barang_id');
        });
    }
};
