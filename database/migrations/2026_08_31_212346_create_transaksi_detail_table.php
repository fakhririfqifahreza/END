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
    Schema::create('transaksi_detail', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('transaksi_id');
        $table->unsignedBigInteger('barang_id')->nullable();
        $table->string('nama_barang');
        $table->double('harga', 15, 2)->default(0);
        $table->double('qty', 8, 2)->default(1);
        $table->double('subtotal', 15, 2)->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_detail');
    }
};
