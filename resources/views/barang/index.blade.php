@extends('layouts.app')

@section('content')
<h2>Data Barang</h2>

<a href="/barang/create">Tambah</a>

@foreach($barang as $b)
<p>
    {{ $b->nama_barang }} | Stok: {{ $b->stok }}
    <a href="/barang/{{ $b->id }}/edit">Edit</a>
    <form action="/barang/{{ $b->id }}" method="POST">
        @csrf @method('DELETE')
        <button>Hapus</button>
    </form>
</p>
@endforeach
@endsection