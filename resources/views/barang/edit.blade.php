<form action="/barang/{{ $barang->id }}" method="POST">
@csrf @method('PUT')
<input name="nama_barang" value="{{ $barang->nama_barang }}">
<input name="stok" value="{{ $barang->stok }}">
<input name="harga" value="{{ $barang->harga }}">
<button>Update</button>
</form>