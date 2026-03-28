<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';

    protected $fillable = [
        'transaksi_id',
        'barang_id',
        'qty',
        'harga_satuan',
        'diskon',       // persen diskon grosir (0–100)
        'subtotal',
    ];

    protected $casts = [
        'qty'          => 'integer',
        'harga_satuan' => 'integer',
        'diskon'       => 'integer',
        'subtotal'     => 'integer',
    ];

    // ── Boot: auto-hitung subtotal ────────────────────────────────────────
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($detail) {
            $hargaSetelahDiskon = $detail->harga_satuan * (1 - ($detail->diskon / 100));
            $detail->subtotal   = (int) round($detail->qty * $hargaSetelahDiskon);
        });
    }

    // ── Relasi ────────────────────────────────────────────────────────────
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}