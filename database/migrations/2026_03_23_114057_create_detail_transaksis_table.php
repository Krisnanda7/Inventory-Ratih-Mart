<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barang')->onDelete('restrict');
            $table->integer('qty')->unsigned();
            $table->unsignedBigInteger('harga_satuan');
            $table->tinyInteger('diskon')->default(0); // % diskon grosir
            $table->unsignedBigInteger('subtotal');
            $table->timestamps();

            $table->index('transaksi_id');
            $table->index('barang_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};