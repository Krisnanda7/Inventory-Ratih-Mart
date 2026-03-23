<h2>Data Transaksi</h2>

@foreach($transaksi as $t)
<p>
    {{ $t->tanggal }} | Total: {{ $t->total }}
    <a href="/transaksi/cetak/{{ $t->id }}">Cetak</a>
</p>
@endforeach