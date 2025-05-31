<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperuserController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\AnggotaJadwalController;


viota
/*
|--------------------------------------------------------------------------
| Landing Page (Umum)
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'))->name('home');

/*
|--------------------------------------------------------------------------
| Auth - Anggota & Customer
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register_customer', [RegisterController::class, 'registerCustomer'])->name('register.customer.submit');
Route::post('/register_anggota', [RegisterController::class, 'registerAnggota'])->name('register.anggota.submit');

/*
|--------------------------------------------------------------------------
| Auth - Superuser & Keuangan
|--------------------------------------------------------------------------
*/
Route::get('/office', [LoginController::class, 'showOfficeLoginForm'])->name('office.login');
Route::post('/office', [LoginController::class, 'officeLogin']);

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard - Anggota & Customer
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:anggota,customer'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Dashboard - Keuangan
|--------------------------------------------------------------------------
*/
Route::get('/keuangan', [KeuanganController::class, 'index'])
    ->middleware(['auth', 'role:keuangan'])
    ->name('keuangan.dashboard');

/*
|--------------------------------------------------------------------------
| Superuser Section
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:superuser'])
     ->prefix('superuser')
     ->name('superuser.')
     ->group(function () {
    // Dashboard & Settings
    Route::get('/', [SuperuserController::class, 'index'])->name('dashboard');
    Route::get('/settings', [SuperuserController::class, 'showSettings'])->name('settings');

    // Kelola Anggota
    Route::get('/kelola-anggota', [SuperuserController::class, 'indexAnggota'])->name('kelola-anggota.index');
    Route::get('/anggota/search', [SuperuserController::class, 'searchAnggota'])->name('anggota.search');
    Route::get('/anggota/export', [SuperuserController::class, 'exportAnggota'])->name('anggota.export');

    // CRUD Anggota
    Route::get('/anggota/create', [SuperuserController::class, 'createAnggota'])->name('anggota.create');
    Route::post('/anggota', [SuperuserController::class, 'storeAnggota'])->name('anggota.store');
    Route::get('/anggota/{id}/edit', [SuperuserController::class, 'editAnggota'])->name('anggota.edit');
    Route::put('/anggota/{id}', [SuperuserController::class, 'updateAnggota'])->name('anggota.update');
    Route::delete('/anggota/{id}', [SuperuserController::class, 'destroyAnggota'])->name('anggota.destroy');

    // Ubah Password Anggota
    Route::get('/anggota/{id}/password', [SuperuserController::class, 'editPasswordAnggota'])->name('anggota.password.edit');
    Route::put('/anggota/{id}/password', [SuperuserController::class, 'updatePasswordAnggota'])->name('anggota.password.update');

    // Route untuk kelola password anggota
    Route::get('/kelola-password', [SuperuserController::class, 'kelolaPasswordAnggota'])->name('kelola-password');

    // CRUD Bundle
    Route::get('/bundle', [SuperuserController::class, 'kelolaBundle'])->name('kelola-bundle.index');
    Route::get('/bundle/create', [SuperuserController::class, 'createBundle'])->name('kelola-bundle.create');
    Route::post('/bundle', [SuperuserController::class, 'storeBundle'])->name('kelola-bundle.store');
    Route::get('/bundle/{id}/edit', [SuperuserController::class, 'editBundle'])->name('kelola-bundle.edit');
    Route::put('/bundle/{id}', [SuperuserController::class, 'updateBundle'])->name('kelola-bundle.update');
    Route::delete('/bundle/{id}', [SuperuserController::class, 'destroyBundle'])->name('kelola-bundle.destroy');

    // CRUD Jadwal Event
    Route::get('/jadwal/event', [SuperuserController::class, 'kelolaJadwalEvent'])->name('jadwal.event.index');
    Route::get('/jadwal/event/create', [SuperuserController::class, 'createJadwalEvent'])->name('jadwal.event.create');
    Route::post('/jadwal/event', [SuperuserController::class, 'storeJadwalEvent'])->name('jadwal.event.store');
    Route::get('/jadwal/event/{id}/edit', [SuperuserController::class, 'editJadwalEvent'])->name('jadwal.event.edit');
    Route::put('/jadwal/event/{id}', [SuperuserController::class, 'updateJadwalEvent'])->name('jadwal.event.update');
    Route::delete('/jadwal/event/{id}', [SuperuserController::class, 'destroyJadwalEvent'])->name('jadwal.event.destroy');

    // CRUD Jadwal Latihan
    Route::get('/jadwal/latihan', [SuperuserController::class, 'kelolaJadwalLatihan'])->name('jadwal.latihan.index');
    Route::get('/jadwal/latihan/create', [SuperuserController::class, 'createJadwalLatihan'])->name('jadwal.latihan.create');
    Route::post('/jadwal/latihan', [SuperuserController::class, 'storeJadwalLatihan'])->name('jadwal.latihan.store');
    Route::get('/jadwal/latihan/{id}/edit', [SuperuserController::class, 'editJadwalLatihan'])->name('jadwal.latihan.edit');
    Route::put('/jadwal/latihan/{id}', [SuperuserController::class, 'updateJadwalLatihan'])->name('jadwal.latihan.update');
    Route::delete('/jadwal/latihan/{id}', [SuperuserController::class, 'destroyJadwalLatihan'])->name('jadwal.latihan.destroy');

    // CRUD Jadwal Rapat
    Route::get('/jadwal/rapat', [SuperuserController::class, 'kelolaJadwalRapat'])->name('jadwal.rapat.index');
    Route::get('/jadwal/rapat/create', [SuperuserController::class, 'createJadwalRapat'])->name('jadwal.rapat.create');
    Route::post('/jadwal/rapat', [SuperuserController::class, 'storeJadwalRapat'])->name('jadwal.rapat.store');
    Route::get('/jadwal/rapat/{id}/edit', [SuperuserController::class, 'editJadwalRapat'])->name('jadwal.rapat.edit');
    Route::put('/jadwal/rapat/{id}', [SuperuserController::class, 'updateJadwalRapat'])->name('jadwal.rapat.update');
    Route::delete('/jadwal/rapat/{id}', [SuperuserController::class, 'destroyJadwalRapat'])->name('jadwal.rapat.destroy');

    // Kelola Paket
    Route::get('/paket', [SuperuserController::class, 'kelolaPaket'])->name('kelola-paket');
});

/*
|--------------------------------------------------------------------------
| Customer - Edit Profil
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/edit', [DashboardController::class, 'editCustomer'])->name('customer.edit');
    Route::post('/customer/update', [DashboardController::class, 'updateCustomer'])->name('customer.update');
});

/*
|--------------------------------------------------------------------------
| Anggota - Lihat Jadwal & Biodata
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:anggota'])
     ->prefix('anggota')
     ->name('anggota.')
     ->group(function () {
    // Dashboard
    Route::get('/', [AnggotaJadwalController::class, 'index'])->name('index');

    // Jadwal
    Route::get('/jadwal/event', [AnggotaJadwalController::class, 'event'])->name('jadwal.event');
    Route::get('/jadwal/latihan', [AnggotaJadwalController::class, 'latihan'])->name('jadwal.latihan');
    Route::get('/jadwal/rapat', [AnggotaJadwalController::class, 'rapat'])->name('jadwal.rapat');

    // Biodata
    Route::get('/biodata', [AnggotaJadwalController::class, 'indexBiodata'])->name('biodata.index');
    Route::get('/biodata/create', [AnggotaJadwalController::class, 'createBiodata'])->name('biodata.create');
    Route::post('/biodata', [AnggotaJadwalController::class, 'storeBiodata'])->name('biodata.store');
    Route::get('/biodata/{biodata}/edit', [AnggotaJadwalController::class, 'editBiodata'])->name('biodata.edit');
    Route::put('/biodata/{biodata}', [AnggotaJadwalController::class, 'updateBiodata'])->name('biodata.update');
    Route::delete('/biodata/{biodata}', [AnggotaJadwalController::class, 'destroyBiodata'])->name('biodata.destroy');
});