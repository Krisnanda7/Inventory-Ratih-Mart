<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today     = Carbon::today();
        $yesterday = Carbon::yesterday();
        $startOfMonth = Carbon::now()->startOfMonth();

        // ── 1. TOTAL BARANG AKTIF ─────────────────────────────────────────
        $totalBarang = Barang::count();

        $barangBaruBulanIni = Barang::where('created_at', '>=', $startOfMonth)->count();

        // ── 2. TRANSAKSI HARI INI ─────────────────────────────────────────
        $transaksiHariIni = Transaksi::whereDate('created_at', $today)->count();

        $transaksiKemarin = Transaksi::whereDate('created_at', $yesterday)->count();

        $selisihTransaksi = $transaksiHariIni - $transaksiKemarin;

        // ── 3. PENDAPATAN HARI INI ────────────────────────────────────────
        $pendapatanHariIni = Transaksi::whereDate('created_at', $today)
            ->where('status', 'lunas')
            ->sum('total_harga');

        $pendapatanKemarin = Transaksi::whereDate('created_at', $yesterday)
            ->where('status', 'lunas')
            ->sum('total_harga');

        $persenPendapatan = $pendapatanKemarin > 0
            ? round((($pendapatanHariIni - $pendapatanKemarin) / $pendapatanKemarin) * 100)
            : 0;

        // ── 4. STOK ALERT ─────────────────────────────────────────────────
        // Barang dengan stok <= stok_minimum
        $stockAlertCount = Barang::whereColumn('stok', '<=', 'stok_minimum')->count();

        $barangStokRendah = Barang::whereColumn('stok', '<=', 'stok_minimum')
            ->orderBy('stok')
            ->limit(10)
            ->get();

        // ── 5. TRANSAKSI TERBARU ──────────────────────────────────────────
        $transaksiTerbaru = Transaksi::with('detailTransaksi')
            ->latest()
            ->limit(7)
            ->get();

        // ── 6. PENJUALAN PER KATEGORI (bulan ini) ────────────────────────
        // Join detail_transaksi → barang untuk ambil kategori
        $kategoriPenjualan = DB::table('detail_transaksi')
            ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->join('barang', 'detail_transaksi.barang_id', '=', 'barang.id')
            ->where('transaksi.created_at', '>=', $startOfMonth)
            ->select(
                'barang.kategori',
                DB::raw('SUM(detail_transaksi.subtotal) as total')
            )
            ->groupBy('barang.kategori')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        return view('dashboard.index', compact(
            'totalBarang',
            'barangBaruBulanIni',
            'transaksiHariIni',
            'selisihTransaksi',
            'pendapatanHariIni',
            'persenPendapatan',
            'stockAlertCount',
            'barangStokRendah',
            'transaksiTerbaru',
            'kategoriPenjualan',
        ))->with('title', 'Dashboard');
    }
}