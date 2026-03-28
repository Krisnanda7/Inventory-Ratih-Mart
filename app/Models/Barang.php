<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'satuan',       // pcs, ktn, dos, bks, botol, dll
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_minimum', // batas minimum sebelum alert
        'deskripsi',
    ];

    protected $casts = [
        'harga_beli'    => 'integer',
        'harga_jual'    => 'integer',
        'stok'          => 'integer',
        'stok_minimum'  => 'integer',
    ];

    // ── Relasi ────────────────────────────────────────────────────────────
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    // ── Scope: stok rendah ────────────────────────────────────────────────
    public function scopeStokRendah($query)
    {
        return $query->whereColumn('stok', '<=', 'stok_minimum');
    }

    // ── Accessor: status stok ─────────────────────────────────────────────
    public function getStatusStokAttribute(): string
    {
        if ($this->stok <= 0) return 'habis';
        if ($this->stok <= ($this->stok_minimum / 2)) return 'kritis';
        if ($this->stok <= $this->stok_minimum) return 'rendah';
        return 'aman';
    }

    // ── Accessor: badge class (untuk view) ────────────────────────────────
    public function getBadgeStokAttribute(): string
    {
        return match ($this->status_stok) {
            'habis'   => 'badge-danger',
            'kritis'  => 'badge-danger',
            'rendah'  => 'badge-warning',
            default   => 'badge-success',
        };
    }
}