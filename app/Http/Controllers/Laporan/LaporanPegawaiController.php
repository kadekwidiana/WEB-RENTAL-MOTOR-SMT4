<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanPegawaiController extends Controller
{
    public function laporanPegawai(Request $request)
    {
        $search = $request->search;

        // $bulan = '07';
        // Mendapatkan nilai $request dari pengguna (misalnya melalui form input)
        $request = isset($_REQUEST['bulan']) ? $_REQUEST['bulan'] : '';

        // Jika $request tidak kosong dan sesuai dengan format yang diinginkan (misalnya 'mm' dengan dua digit), gunakan nilai $request sebagai $bulan
        if (!empty($request) && preg_match('/^\d{2}$/', $request)) {
            $bulan = $request;
        } else {
            $bulan = Carbon::now()->format('m');
        }
        $bulan;
        // $tahun = '2023';
        $request2 = isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : '';

        // Jika $request2 tidak kosong dan sesuai dengan format yang diinginkan (misalnya 'mm' dengan dua digit), gunakan nilai $request2 sebagai $tahun
        if (!empty($request2) && preg_match('/^\d{4}$/', $request2)) {
            $tahun = $request2;
        } else {
            $tahun = Carbon::now()->format('Y');
        }
        $tahun;

        if ($bulan !=  Carbon::now()->format('m') | $tahun !=  Carbon::now()->format('Y')) {
            $paginate = 100;
        } else {
            $paginate = 10;
        }

        $pegawais = User::with(['transaksi', 'pengeluaran'])->orWhere('nama_pegawai', 'like', '%' . $search . '%')->paginate($paginate);
        return view('laporan.laporan-pegawai', [
            'title' => 'Laporan Pegawai',
            'active' => 'Laporan'
        ], compact(
            'pegawais',
            'bulan',
            'tahun',
        ));
    }
}
