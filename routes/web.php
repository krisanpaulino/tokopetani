<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PetaniController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Middleware\AdminLogin;
use App\Http\Middleware\PembeliLogin;
use App\Http\Middleware\PetaniLogin;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('front.index');
Route::get('/search', [HomeController::class, 'search'])->name('front.search'); //ini belum bikin

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/signup', [AuthController::class, 'registrasiPembeli'])->name('signup');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
Route::post('/signup', [AuthController::class, 'registrasiPost'])->name('signup.post');
// Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');

// Frontend
// Route::post('/order', [HomeController::class, 'orderPost'])->name('order');
Route::get('/profil', [HomeController::class, 'profil'])->name('front.profil')->middleware(PembeliLogin::class);
Route::get('/edit', [HomeController::class, 'editProfil'])->name('profil.edit')->middleware(PembeliLogin::class);
Route::post('/update-profil', [PembeliController::class, 'update'])->name('profil.update')->middleware(PembeliLogin::class);
Route::get('/order', [HomeController::class, 'orderList'])->name('front.order')->middleware(PembeliLogin::class);
Route::post('/order', [HomeController::class, 'orderPost'])->name('order')->middleware(PembeliLogin::class);
Route::post('/place-order', [HomeController::class, 'placeOrder'])->name('order.place')->middleware(PembeliLogin::class);
Route::get('/cart', [HomeController::class, 'cart'])->name('cart')->middleware(PembeliLogin::class);
Route::post('/cart/delete', [HomeController::class, 'deleteCart'])->name('cart.delete')->middleware(PembeliLogin::class);
Route::get('/checkout/{id}', [HomeController::class, 'checkout'])->name('checkout')->middleware(PembeliLogin::class);
Route::get('/order/{id}', [HomeController::class, 'detail'])->name('order.detail')->middleware(PembeliLogin::class);
Route::post('/order/upload', [HomeController::class, 'uploadBukti'])->name('order.upload')->middleware(PembeliLogin::class);

Route::get('/ajax-carilokasi', [AjaxController::class, 'lokasi'])->name('ajax.getLokasi');
Route::get('/ajax-cost', [AjaxController::class, 'cost'])->name('ajax.getCost');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::prefix('admin')->middleware(AdminLogin::class)->group(function () {
    Route::get('/petani', [PetaniController::class, 'index'])->name('petani.index');
    Route::get('/petani/tambah', [PetaniController::class, 'tambah'])->name('petani.tambah');
    Route::get('/petani/edit/{petani_id}', [PetaniController::class, 'edit'])->name('petani.edit');
    Route::get('/petani/{petani_id}', [PetaniController::class, 'view'])->name('petani.detail');
    Route::post('/petani/insert', [PetaniController::class, 'insert'])->name('petani.insert');
    Route::post('/petani/update', [PetaniController::class, 'update'])->name('petani.update');
    Route::post('/petani/delete', [PetaniController::class, 'delete'])->name('petani.delete');

    Route::get('/pembeli', [PembeliController::class, 'index'])->name('pembeli.index');
    Route::get('/pembeli/edit/{pembeli_id}', [PembeliController::class, 'edit'])->name('pembeli.edit');
    Route::get('/riwayat/{pembeli_id}', [LaporanController::class, 'riwayat'])->name('admin.riwayat-pembeli');

    Route::post('/pembeli/update', [PembeliController::class, 'update'])->name('pembeli.update');
    Route::get('/produk', [ProdukController::class, 'tersedia'])->name('admin.produk');
    Route::get('/produk-petani/{id}', [ProdukController::class, 'byPetani'])->name('admin.produk-petani');

    Route::get('/order', [TransaksiController::class, 'order'])->name('admin.order');
    Route::get('/order/detail/{id}', [TransaksiController::class, 'detailAdmin'])->name('admin.order.detail');
    Route::post('/order/proses', [TransaksiController::class, 'prosesPost'])->name('order.proses');
    Route::post('/order/selesai', [TransaksiController::class, 'selesaiPost'])->name('admin.order.selesai');

    Route::get('/order/masuk', [TransaksiController::class, 'masuk'])->name('admin.order.masuk');
    Route::get('/order/diproses', [TransaksiController::class, 'diproses'])->name('admin.order.diproses');
    Route::get('/order/selesai', [TransaksiController::class, 'selesai'])->name('admin.order.selesai');
    Route::get('/laporan', [LaporanController::class, 'pembelian'])->name('admin.laporan');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('admin.cetak-laporan');
});
Route::prefix('petani')->middleware(PetaniLogin::class)->group(function () {
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/tambah', [ProdukController::class, 'tambah'])->name('produk.tambah');
    Route::get('/produk/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::post('/produk/insert', [ProdukController::class, 'insert'])->name('produk.insert');
    Route::post('/produk/update', [ProdukController::class, 'update'])->name('produk.update');
    Route::post('/produk/delete', [ProdukController::class, 'delete'])->name('produk.delete');
    Route::get('/order', [TransaksiController::class, 'order'])->name('petani.order');
    Route::get('/order/masuk', [TransaksiController::class, 'masuk'])->name('petani.order.masuk');
    Route::get('/order/diproses', [TransaksiController::class, 'diproses'])->name('petani.order.diproses');
    Route::get('/order/selesai', [TransaksiController::class, 'selesai'])->name('petani.order.selesai');
    Route::get('/order/detail/{id}', [TransaksiController::class, 'detail'])->name('petani.order.detail');
    Route::post('/order/kirim', [TransaksiController::class, 'kirimPost'])->name('order.kirim');
    Route::post('/order/selesai', [TransaksiController::class, 'selesaiPost'])->name('order.selesai');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('petani.cetak-laporan');

    Route::get('/laporan', [LaporanController::class, 'pembelian'])->name('petani.laporan');
});
