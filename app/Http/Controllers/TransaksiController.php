<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use PDF;

class TransaksiController extends Controller
{
    //
    public function index()
    {
        $transaksi = Transaksi::latest()->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('transaksi.create', compact('barang'));
    }
    
    public function store(Request $request)
    {
        $transaksi = Transaksi::create([
            'tanggal' => now(),
            'total' => 0
        ]);

        $total = 0;

        foreach ($request->barang_id as $key => $id) {
            $barang = Barang::find($id);

            $qty = $request->qty[$key];
            $subtotal = $qty * $barang->harga;

            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'barang_id' => $id,
                'qty' => $qty,
                'harga' => $barang->harga,
                'subtotal' => $subtotal
            ]);

            // Kurangi stok
            $barang->stok -= $qty;
            $barang->save();

            $total += $subtotal;
        }

        $transaksi->update(['total' => $total]);

        return redirect('/transaksi');
    }

    public function cetak($id)
    {
        $transaksi = Transaksi::with('detail.barang')->find($id);

        $pdf = PDF::loadView('transaksi.nota', compact('transaksi'));
        return $pdf->download('nota.pdf');
    }

}
