<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontPageController;
use App\Http\Controllers\Report\ReportMotorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;


// profile
Route::get('/profile', [ProfileController::class, 'profile'])->middleware(['auth'])->name('profile');
Route::post('/profile', [ProfileController::class, 'change_profile'])->middleware(['auth'])->name('profile.change');

// change password
Route::get('/change-password', [ProfileController::class, 'password'])->middleware(['auth'])->name('change-password');
Route::post('/change-password', [ProfileController::class, 'change_password'])->middleware(['auth'])->name('change-password.change');

require __DIR__ . '/auth.php';


// AUTH
Route::middleware('auth',)->group(function () {
    Route::middleware('admin')->group(function () {
        // Transaksi
        Route::resource('/transaksi', TransaksiController::class);
        Route::get('/transaksi/{kode_transaksi}/pengembalian', [TransaksiController::class, 'pengembalianForm'])->name('transaksi.pengembalianForm');
        Route::post('/transaksi/{kode_transaksi}/pengembalian', [TransaksiController::class, 'pengembalian'])->name('transaksi.pengembalian');
        Route::get('/transaksi/create/data-transaksi', [TransaksiController::class, 'viewadd'])->name('transaksi.viewadd');
        Route::post('/transaksi/create/data-transaksi', [TransaksiController::class, 'tambah'])->name('transaksi.tambah');
        // Route::get('/motors', [MotorController::class, 'index'])->name('motor.index');
        // Kelola motor
        Route::resource('/motor', MotorController::class);
        // Penyewa
        Route::resource('/penyewa', PenyewaController::class);
        // Pengeluaran
        Route::get('/pengeluarans', [PengeluaranController::class, 'index'])->name('pengeluaran.index');

        // >= MANAJER
        Route::middleware('manajer')->group(function () {

            // Pengeluaran
            Route::resource('/pengeluaran', PengeluaranController::class);
            // Kelola pegawai
            Route::resource('/pegawai', UserController::class);

            // Auth Owner/Pemilik
            Route::middleware('owner')->group(function () {
                Route::patch('/pegawai/{id}/update-status', [UserController::class, 'statusPegawai'])->name('pegawai.statusPegawai');
                Route::patch('/pegawai/{id}/update', [UserController::class, 'statusNonAktif'])->name('pegawai.statusNonAktif');
                Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
                Route::get('/dashboard/report-motor', [ReportMotorController::class, 'reportMotor']);
                Route::get('/dashboard/report-motor/{plat_motor}/detail', [ReportMotorController::class, 'detailReportMotor']);
            });
        });

        // tampilan pertama berhasil login
        Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome.index');
    });
});


// Frontpage Rental Motor
Route::get('/', [FrontPageController::class, 'viewHome'])->name('frontpage.home');
Route::get('/about', [FrontPageController::class, 'viewAbout'])->name('frontpage.about');
Route::get('/view-motor', [FrontPageController::class, 'viewMotor'])->name('frontpage.motors');
Route::get('/contact', [FrontPageController::class, 'viewContact'])->name('frontpage.contact');
