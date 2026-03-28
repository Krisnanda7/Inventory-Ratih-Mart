<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with('user')->latest();

        // Filter tanggal
        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian pelanggan / kode
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('pelanggan', 'like', "%{$q}%")
                   ->orWhere('kode_transaksi', 'like', "%{$q}%");
            });
        }

        // Summary hari ini
        $totalHariIni     = Transaksi::whereDate('created_at', today())->count();
        $pendapatanHariIni = Transaksi::whereDate('created_at', today())->where('status', 'lunas')->sum('total_harga');
        $piutangBelumLunas = Transaksi::where('status', 'piutang')->sum('total_harga');
        $stockAlertCount  = Barang::whereColumn('stok', '<=', 'stok_minimum')->count();

        $transaksi = $query->paginate(15)->withQueryString();

        return view('transaksi.index', compact(
            'transaksi',
            'totalHariIni',
            'pendapatanHariIni',
            'piutangBelumLunas',
            'stockAlertCount',
        ))->with('title', 'Daftar Transaksi');
    }

    public function create()
    {
        $stockAlertCount = Barang::whereColumn('stok', '<=', 'stok_minimum')->count();
        return view('transaksi.create', compact('stockAlertCount'))->with('title', 'Buat Transaksi');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan'       => 'nullable|string|max:100',
            'status'          => 'required|in:lunas,piutang',
            'total_bayar'     => 'required|integer|min:0',
            'catatan'         => 'nullable|string',
            'items'           => 'required|array|min:1',
            'items.*.barang_id'    => 'required|exists:barang,id',
            'items.*.qty'          => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|integer|min:0',
            'items.*.diskon'       => 'nullable|integer|min:0|max:100',
        ]);

        DB::transaction(function () use ($request) {
            // Hitung total
            $totalHarga = 0;
            $items = [];

            foreach ($request->items as $item) {
                $diskon   = $item['diskon'] ?? 0;
                $subtotal = (int) round($item['qty'] * $item['harga_satuan'] * (1 - $diskon / 100));
                $totalHarga += $subtotal;
                $items[] = array_merge($item, ['subtotal' => $subtotal, 'diskon' => $diskon]);
            }

            $kembalian = $request->total_bayar - $totalHarga;

            // Buat transaksi
            $transaksi = Transaksi::create([
                'pelanggan'   => $request->pelanggan,
                'total_harga' => $totalHarga,
                'total_bayar' => $request->total_bayar,
                'kembalian'   => $kembalian,
                'status'      => $request->status,
                'catatan'     => $request->catatan,
                'user_id'     => auth()->id(),
            ]);

            // Simpan detail & kurangi stok
            foreach ($items as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id'    => $item['barang_id'],
                    'qty'          => $item['qty'],
                    'harga_satuan' => $item['harga_satuan'],
                    'diskon'       => $item['diskon'],
                    'subtotal'     => $item['subtotal'],
                ]);

                // Kurangi stok
                Barang::where('id', $item['barang_id'])->decrement('stok', $item['qty']);
            }
        });

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load('detailTransaksi.barang', 'user');
        $stockAlertCount = Barang::whereColumn('stok', '<=', 'stok_minimum')->count();

        return view('transaksi.show', compact('transaksi', 'stockAlertCount'))
            ->with('title', 'Detail ' . $transaksi->kode_transaksi);
    }

    public function nota(Transaksi $transaksi)
    {
        $transaksi->load('detailTransaksi.barang', 'user');
        return view('transaksi.nota', compact('transaksi'));
    }

    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate(['status' => 'required|in:lunas,piutang,batal']);

        $transaksi->update(['status' => $request->status]);

        // Jika dibatalkan, kembalikan stok
        if ($request->status === 'batal' && $transaksi->getOriginal('status') !== 'batal') {
            foreach ($transaksi->detailTransaksi as $detail) {
                Barang::where('id', $detail->barang_id)->increment('stok', $detail->qty);
            }
        }

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        // Hanya izinkan hapus jika batal
        if ($transaksi->status !== 'batal') {
            return back()->with('error', 'Hanya transaksi berstatus "Batal" yang dapat dihapus.');
        }

        $transaksi->delete();
        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}