<h2>Nota</h2>

<p>Tanggal: {{ $transaksi->tanggal }}</p>

@foreach($transaksi->detail as $d)
<p>
    {{ $d->barang->nama_barang }} |
    {{ $d->qty }} x {{ $d->harga }} = {{ $d->subtotal }}
</p>
@endforeach

<h3>Total: {{ $transaksi->total }}</h3>