<form action="/barang" method="POST">
@csrf
<input name="nama_barang" placeholder="Nama">
<input name="stok" placeholder="Stok">
<input name="harga" placeholder="Harga">
<button>Simpan</button>
</form>