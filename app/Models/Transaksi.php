<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'kode_transaksi',
        'pelanggan',        // nama pembeli / toko grosir pelanggan
        'total_harga',
        'total_bayar',
        'kembalian',
        'status',           // lunas | piutang | batal
        'catatan',
        'user_id',          // kasir yang melayani
    ];

    protected $casts = [
        'total_harga' => 'integer',
        'total_bayar' => 'integer',
        'kembalian'   => 'integer',
    ];

    // ── Boot: auto-generate kode transaksi ───────────────────────────────
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi) {
            $latest = static::whereDate('created_at', today())->count() + 1;
            $tanggal = now()->format('ymd');
            $transaksi->kode_transaksi = 'TRX-' . $tanggal . '-' . str_pad($latest, 3, '0', STR_PAD_LEFT);
        });
    }

    // ── Relasi ────────────────────────────────────────────────────────────
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Scope ─────────────────────────────────────────────────────────────
    public function scopeHariIni($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeLunas($query)
    {
        return $query->where('status', 'lunas');
    }

    // ── Accessor ──────────────────────────────────────────────────────────
    public function getBadgeStatusAttribute(): string
    {
        return match ($this->status) {
            'lunas'   => 'badge-success',
            'piutang' => 'badge-warning',
            'batal'   => 'badge-danger',
            default   => 'badge-info',
        };
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            'lunas'   => 'Lunas',
            'piutang' => 'Piutang',
            'batal'   => 'Batal',
            default   => 'Proses',
        };
    }
}