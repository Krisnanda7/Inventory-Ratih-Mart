<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    //
    public function index()
    {
        $barang = Barang::all();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        Barang::create($request->all());
        return redirect('/barang');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->update($request->all());
        return redirect('/barang');
    }

    public function destroy($id)
    {
        Barang::destroy($id);
        return redirect('/barang');
    }
}
