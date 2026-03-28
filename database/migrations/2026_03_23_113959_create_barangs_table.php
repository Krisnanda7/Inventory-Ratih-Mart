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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 20)->unique(); // ← wajib ada
            $table->string('nama_barang', 150);
            $table->string('kategori', 60)->nullable()->index();
            $table->string('satuan', 20)->default('pcs');
            $table->unsignedBigInteger('harga_beli')->default(0);
            $table->unsignedBigInteger('harga_jual')->default(0);
            $table->integer('stok')->default(0);
            $table->integer('stok_minimum')->default(5);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
