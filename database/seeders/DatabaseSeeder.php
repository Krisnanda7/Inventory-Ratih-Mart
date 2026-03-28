<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── User admin ────────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'ratih@tokogrosir.com'],
            [
                'name'     => 'Ratih',
                'password' => Hash::make('password'),
            ]
        );

        // ── Barang contoh (toko grosiran) ─────────────────────────────────
        $barang = [
            // Sembako
            ['kode_barang' => 'SBK-001', 'nama_barang' => 'Minyak Goreng Bimoli 2L',   'kategori' => 'Sembako',   'satuan' => 'ktn', 'harga_beli' => 26000, 'harga_jual' => 28500, 'stok' => 4,   'stok_minimum' => 10],
            ['kode_barang' => 'SBK-002', 'nama_barang' => 'Gula Pasir Rose Brand 1kg',  'kategori' => 'Sembako',   'satuan' => 'ktn', 'harga_beli' => 13500, 'harga_jual' => 14500, 'stok' => 8,   'stok_minimum' => 12],
            ['kode_barang' => 'SBK-003', 'nama_barang' => 'Beras Pandan Wangi 5kg',     'kategori' => 'Sembako',   'satuan' => 'ktn', 'harga_beli' => 68000, 'harga_jual' => 72000, 'stok' => 45,  'stok_minimum' => 10],
            ['kode_barang' => 'SBK-004', 'nama_barang' => 'Tepung Terigu Segitiga 1kg', 'kategori' => 'Sembako',   'satuan' => 'ktn', 'harga_beli' => 10500, 'harga_jual' => 11500, 'stok' => 30,  'stok_minimum' => 8],
            ['kode_barang' => 'SBK-005', 'nama_barang' => 'Minyak Tanah 5L',            'kategori' => 'Sembako',   'satuan' => 'botol', 'harga_beli' => 35000, 'harga_jual' => 38000, 'stok' => 20, 'stok_minimum' => 5],

            // Mie & Makanan Instan
            ['kode_barang' => 'MIE-001', 'nama_barang' => 'Indomie Goreng',             'kategori' => 'Mie Instan','satuan' => 'dos', 'harga_beli' => 95000, 'harga_jual' => 102000, 'stok' => 6,  'stok_minimum' => 10],
            ['kode_barang' => 'MIE-002', 'nama_barang' => 'Mie Sedaap Kuah',            'kategori' => 'Mie Instan','satuan' => 'dos', 'harga_beli' => 93000, 'harga_jual' => 100000, 'stok' => 22, 'stok_minimum' => 8],
            ['kode_barang' => 'MIE-003', 'nama_barang' => 'Pop Mie Ayam',               'kategori' => 'Mie Instan','satuan' => 'dos', 'harga_beli' => 55000, 'harga_jual' => 62000,  'stok' => 18, 'stok_minimum' => 6],

            // Minuman
            ['kode_barang' => 'MNM-001', 'nama_barang' => 'Aqua Galon 19L',             'kategori' => 'Minuman',   'satuan' => 'pcs', 'harga_beli' => 20000, 'harga_jual' => 22000, 'stok' => 35,  'stok_minimum' => 5],
            ['kode_barang' => 'MNM-002', 'nama_barang' => 'Teh Botol Sosro 330ml',      'kategori' => 'Minuman',   'satuan' => 'ktn', 'harga_beli' => 48000, 'harga_jual' => 54000, 'stok' => 28,  'stok_minimum' => 6],
            ['kode_barang' => 'MNM-003', 'nama_barang' => 'Kopi Kapal Api Sachet',      'kategori' => 'Minuman',   'satuan' => 'bks', 'harga_beli' => 24000, 'harga_jual' => 27000, 'stok' => 10,  'stok_minimum' => 12],
            ['kode_barang' => 'MNM-004', 'nama_barang' => 'Pocari Sweat 500ml',         'kategori' => 'Minuman',   'satuan' => 'ktn', 'harga_beli' => 73000, 'harga_jual' => 80000, 'stok' => 15,  'stok_minimum' => 5],

            // Snack
            ['kode_barang' => 'SNK-001', 'nama_barang' => 'Chitato Sapi Panggang 68g',  'kategori' => 'Snack',     'satuan' => 'dos', 'harga_beli' => 58000, 'harga_jual' => 65000, 'stok' => 24, 'stok_minimum' => 6],
            ['kode_barang' => 'SNK-002', 'nama_barang' => 'Oreo Biskuit 137g',          'kategori' => 'Snack',     'satuan' => 'dos', 'harga_beli' => 52000, 'harga_jual' => 58000, 'stok' => 30, 'stok_minimum' => 6],
            ['kode_barang' => 'SNK-003', 'nama_barang' => 'Wafer Tango Coklat',         'kategori' => 'Snack',     'satuan' => 'dos', 'harga_beli' => 44000, 'harga_jual' => 50000, 'stok' => 16, 'stok_minimum' => 5],

            // Kebersihan Rumah
            ['kode_barang' => 'KBR-001', 'nama_barang' => 'Sabun Cuci Piring Mama 800ml', 'kategori' => 'Produk Rumah', 'satuan' => 'ktn', 'harga_beli' => 22000, 'harga_jual' => 25000, 'stok' => 3, 'stok_minimum' => 8],
            ['kode_barang' => 'KBR-002', 'nama_barang' => 'Rinso Cair 1.8L',            'kategori' => 'Produk Rumah', 'satuan' => 'ktn', 'harga_beli' => 32000, 'harga_jual' => 36000, 'stok' => 20, 'stok_minimum' => 6],
            ['kode_barang' => 'KBR-003', 'nama_barang' => 'Sabun Mandi Lifebuoy 90g',   'kategori' => 'Produk Rumah', 'satuan' => 'ktn', 'harga_beli' => 6500,  'harga_jual' => 7500,  'stok' => 55, 'stok_minimum' => 10],
            ['kode_barang' => 'KBR-004', 'nama_barang' => 'Pembalut Charm 20s',         'kategori' => 'Produk Rumah', 'satuan' => 'ktn', 'harga_beli' => 18000, 'harga_jual' => 21000, 'stok' => 25, 'stok_minimum' => 6],

            // Rokok
            ['kode_barang' => 'RKK-001', 'nama_barang' => 'Gudang Garam Surya 16',      'kategori' => 'Rokok',     'satuan' => 'slop', 'harga_beli' => 220000, 'harga_jual' => 235000, 'stok' => 12, 'stok_minimum' => 3],
            ['kode_barang' => 'RKK-002', 'nama_barang' => 'Sampoerna Mild 16',          'kategori' => 'Rokok',     'satuan' => 'slop', 'harga_beli' => 235000, 'harga_jual' => 250000, 'stok' => 8,  'stok_minimum' => 3],
        ];

        foreach ($barang as $b) {
            Barang::firstOrCreate(['kode_barang' => $b['kode_barang']], $b);
        }
    }
}