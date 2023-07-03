<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use Illuminate\Http\Request;

class LaporanMotorController extends Controller
{
    public function laporanMotor(Request $request)
    {
        // Ambil data motor dari sumber data yang relevan, misalnya database
        $dataMotor = Motor::all();

        // Ambil bulan sekarang
        $bulanSekarang = date('Y-m');

        // Buat array untuk menyimpan informasi laporan per bulan
        $laporanPerBulan = [];

        // Iterasi melalui data motor dan tambahkan informasi laporan per bulan
        foreach ($dataMotor as $motor) {
            // Filter transaksi hanya pada bulan sekarang
            $transaksiBulanIni = $motor->transaksi->where('created_at', 'like', $bulanSekarang . '%');

            // Hitung total transaksi pada bulan sekarang
            $totalTransaksiBulanIni = $transaksiBulanIni->sum('total');

            // Tambahkan informasi laporan per bulan
            $laporanPerBulan[$motor->id] = [
                'bulan' => $bulanSekarang,
                'totalTransaksi' => $totalTransaksiBulanIni,
            ];
        }

        return view('laporan.motor', [
            'title' => 'Laporan motor',
            'active' => 'Laporan',
            'laporanPerBulan' => $laporanPerBulan
        ]);
    }
}
