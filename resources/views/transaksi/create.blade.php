<form action="/transaksi" method="POST">
@csrf

@foreach($barang as $b)
    <input type="checkbox" name="barang_id[]" value="{{ $b->id }}">
    {{ $b->nama_barang }}
    <input type="number" name="qty[]" placeholder="Qty">
@endforeach

<button>Simpan Transaksi</button>
</form>