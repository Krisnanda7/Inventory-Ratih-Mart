<x-app-layout>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500">Selamat datang di Sistem Toko Ratih</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500">Total Barang</p>
                    <h2 class="text-3xl font-bold text-gray-800">100</h2>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    📦
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500">Transaksi Hari Ini</p>
                    <h2 class="text-3xl font-bold text-gray-800">20</h2>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    💳
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500">Pendapatan</p>
                    <h2 class="text-3xl font-bold text-gray-800">Rp 2.000.000</h2>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    💰
                </div>
            </div>
        </div>

    </div>
</x-app-layout>