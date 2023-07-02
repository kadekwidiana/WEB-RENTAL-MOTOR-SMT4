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
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Laporan\LaporanMotorController;

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

        // view penyewaan
        Route::get('/penyewaan', [TransaksiController::class, 'penyewaan'])->name('transaksi.penyewaan');
        // view pengembalian
        Route::get('/pengembalian', [TransaksiController::class, 'listPengembalian'])->name('transaksi.listPengembalian');
        // view riwayat transaksi
        Route::get('/riwayatTransaksi', [TransaksiController::class, 'listRiwayatTransaksi'])->name('transaksi.listRiwayatTransaksi');

        Route::get('/transaksi/{kode_transaksi}/pengembalian', [TransaksiController::class, 'pengembalianForm'])->name('transaksi.pengembalianForm');
        Route::post('/transaksi/{kode_transaksi}/pengembalian', [TransaksiController::class, 'pengembalian'])->name('transaksi.pengembalian');
        Route::get('/transaksi/create/data-transaksi', [TransaksiController::class, 'viewadd'])->name('transaksi.viewadd');
        Route::post('/transaksi/create/data-transaksi', [TransaksiController::class, 'tambah'])->name('transaksi.tambah');
        // Melihat data motor
        Route::get('/motor', [MotorController::class, 'index'])->name('motor.index');
        // Penyewa
        Route::resource('/penyewa', PenyewaController::class);
        // Pengeluaran
        Route::get('/pengeluarans', [PengeluaranController::class, 'index'])->name('pengeluaran.index');

        // >= MANAJER
        Route::middleware('manajer')->group(function () {
            // Kelola data motor
            Route::get('/motor/create', [MotorController::class, 'create'])->name('motor.create');
            Route::post('/motor', [MotorController::class, 'store'])->name('motor.store');
            Route::get('/motor/{plat_motor}/edit', [MotorController::class, 'edit'])->name('motor.edit');
            Route::put('/motor/{plat_motor}', [MotorController::class, 'update'])->name('motor.update');
            Route::delete('/motor/{plat_motor}', [MotorController::class, 'destroy'])->name('motor.destroy');

            // Pengeluaran
            Route::resource('/pengeluaran', PengeluaranController::class);
            // Print Laporan pengeluaran
            Route::get('generatePdf-laporan-pengeluaran', [PengeluaranController::class, 'generatePdf'])->name('generate-pdf');
            // Kelola pegawai
            Route::resource('/pegawai', UserController::class);

            // Auth Owner/Pemilik
            Route::middleware('owner')->group(function () {
                Route::patch('/pegawai/{id}/update-status', [UserController::class, 'statusPegawai'])->name('pegawai.statusPegawai');
                Route::patch('/pegawai/{id}/update', [UserController::class, 'statusNonAktif'])->name('pegawai.statusNonAktif');
                Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
                Route::get('/dashboard/report-motor', [ReportMotorController::class, 'reportMotor'])->name('report.motor');
                Route::get('/dashboard/report-motor/{plat_motor}/detail', [ReportMotorController::class, 'detailReportMotor']);

                // laporan 
                Route::get('/laporanMotor', [LaporanMotorController::class, 'laporanMotor'])->name('laporan.motor');
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
Route::resource('contact-admin', ContactController::class);
