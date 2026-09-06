<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Language Route
Route::get('/language/{locale}', [LanguageController::class, 'change'])->name('language.change');

// Halaman utama
Route::get('/', function () {
    return view('home');
})->name('home');

// Produk dan pencarian otomatis
Route::get('/produk', [BarangController::class, 'index'])->name('produk.index');
Route::get('/produk/search', [BarangController::class, 'search'])->name('produk.search');
Route::post('/produk', [BarangController::class, 'store'])->name('produk.store');
Route::put('/produk/{id}/update-stok', [BarangController::class, 'updateStok'])->name('produk.updateStok');
Route::delete('/produk/{id}', [BarangController::class, 'destroy'])->name('produk.destroy');

// Keranjang - Bisa diakses tanpa login (menggunakan session)
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang/hapus-semua', [KeranjangController::class, 'hapusSemua'])->name('keranjang.hapus.semua');
Route::post('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
Route::post('/keranjang/update/{id}', [KeranjangController::class, 'updateQuantity'])->name('keranjang.update');

// Checkout - Hanya bisa diakses setelah login
Route::middleware(['auth'])->group(function () {
    Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');
});

// Halaman lainnya
Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/maps', 'maps')->name('maps');
Route::view('/kontak', 'kontak')->name('kontak');

// AUTH ROUTES
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// ADMIN AUTH ROUTES
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [App\Http\Controllers\Admin\AdminAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [App\Http\Controllers\Admin\AdminAuthController::class, 'register'])->name('register.submit');
    Route::post('/logout', [App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('logout');
});

// ADMIN & PEMILIK WARUNG ROUTES
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\KasirController::class, 'index'])->name('dashboard');

    // 1. Kasir (POS)
    Route::get('/kasir', [App\Http\Controllers\Admin\KasirController::class, 'index'])->name('kasir');
    Route::post('/kasir/proses', [App\Http\Controllers\Admin\KasirController::class, 'store'])->name('kasir.store');

    // 2. Transaksi (Daftar & Update Status)
    Route::get('/transaksi', [App\Http\Controllers\Admin\TransaksiController::class, 'index'])->name('transaksi');
    Route::post('/transaksi/{id}/update-status', [App\Http\Controllers\Admin\TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');
    Route::get('/transaksi/check-new', [App\Http\Controllers\Admin\TransaksiController::class, 'checkNewTransactions'])->name('transaksi.checkNew');

    // 3. Laporan Keuangan
    Route::get('/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/export-excel', [App\Http\Controllers\Admin\LaporanController::class, 'exportExcel'])->name('laporan.export');

    // 4. Kelola Produk (Pemilik Warung)
    Route::get('/produk', [App\Http\Controllers\Admin\ProdukController::class, 'index'])->name('produk');
    Route::get('/produk/tambah', [App\Http\Controllers\Admin\ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk/simpan', [App\Http\Controllers\Admin\ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [App\Http\Controllers\Admin\ProdukController::class, 'edit'])->name('produk.edit');
    Route::post('/produk/{id}/update', [App\Http\Controllers\Admin\ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}/hapus', [App\Http\Controllers\Admin\ProdukController::class, 'destroy'])->name('produk.destroy');
});

// ADMIN & PEMILIK WARUNG ROUTES
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // ... route kasir, transaksi, laporan, produk ...

    // 5. Kelola Akun Admin & Kasir
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
});

// Route sementara untuk fix stok (hapus setelah digunakan)
Route::get('/fix-stok', function() {
    $produks = App\Models\Barang::all();
    $fixed = [];

    foreach ($produks as $produk) {
        $stokLama = $produk->stok_barang;

        // Ekstrak hanya angka pertama dan satuan (jika ada)
        preg_match('/^(\d+(?:\.\d+)?)\s*(.*)$/', trim($stokLama), $matches);

        if (isset($matches[1])) {
            $angka = floatval($matches[1]);
            $satuan = isset($matches[2]) ? trim($matches[2]) : '';

            // Format ulang: angka + satuan (jika ada)
            if ($angka <= 0) {
                $produk->stok_barang = '0';
            } else {
                $angkaFormatted = (fmod($angka, 1) == 0) ? intval($angka) : $angka;
                $produk->stok_barang = !empty($satuan) ? $angkaFormatted . ' ' . $satuan : (string)$angkaFormatted;
            }

            if ($stokLama !== $produk->stok_barang) {
                $produk->save();
                $fixed[] = [
                    'id' => $produk->id_barang,
                    'nama' => $produk->nama_barang,
                    'stok_lama' => $stokLama,
                    'stok_baru' => $produk->stok_barang
                ];
            }
        }
    }

    return response()->json([
        'message' => 'Stok berhasil dibersihkan',
        'total_fixed' => count($fixed),
        'details' => $fixed
    ]);
});
