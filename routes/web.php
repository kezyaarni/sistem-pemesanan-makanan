<?php

// Controller buat urusan profil user (bawaan Laravel Breeze)
use App\Http\Controllers\ProfileController;
// Buat bikin route-route di bawah ini
use Illuminate\Support\Facades\Route;
// Controller buat ngurus data makanan (CRUD menu di admin)
use App\Http\Controllers\FoodController;
// Controller buat ngurus pesanan (checkout, dashboard admin, update status pesanan)
use App\Http\Controllers\OrderController;

// Halaman utama, ini yang dilihat customer (katalog menu)
// Kalau buka "/", langsung jalanin index() di OrderController
//get buat ambil data, cuman liat halaman giru
Route::get('/', [OrderController::class, 'index'])->name('customer.index');

// Pas customer klik "kirim pesanan", form-nya kirim POST ke "/checkout"
// lalu diproses sama method store() buat disimpan ke database
//postnya in buat ngirim/simpen data ke server
Route::post('/checkout', [OrderController::class, 'store'])->name('customer.checkout');


// Biar dashboard bawaan Breeze langsung nyambung ke Dashboard Admin kita
// Jadi pas login, user diarahin ke "/dashboard" yang isinya udah dashboard admin
Route::get('/dashboard', [OrderController::class, 'adminDashboard'])
    // Wajib login dulu ("auth"), dan email-nya udah diverifikasi ("verified")
    ->middleware(['auth', 'verified'])
    // Nama route-nya "dashboard" (ini emang default dari Breeze)
    ->name('dashboard');

// Semua route di dalam sini cuma bisa diakses kalau udah login
Route::middleware('auth')->group(function () {

    // Halaman buat edit profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Pas form edit profil disubmit, data profil di-update
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Kalau user hapus akun, data profilnya dihapus dari sini
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Alias buat admin dashboard
    // Jadi halaman yang sama bisa diakses lewat 2 alamat: "/dashboard" atau "/admin/dashboard"
    Route::get('/admin/dashboard', [OrderController::class, 'adminDashboard'])->name('admin.dashboard');

    // Buat admin ubah status pesanan tertentu (misal dari "pending" ke "selesai")
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    // Ini bikin otomatis 7 route CRUD (tambah, edit, hapus, dll) buat kelola data makanan
    // di "/admin/foods", semuanya ditangani FoodController
    Route::resource('/admin/foods', FoodController::class);
});

// Panggil file routes/auth.php, isinya route bawaan Breeze
// (login, register, logout, lupa password, verifikasi email, dll)
require __DIR__.'/auth.php';