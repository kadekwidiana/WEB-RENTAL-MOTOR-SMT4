<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Penyewa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanPenyewaController extends Controller
{
    public function laporanPenyewa(Request $request)
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

        $jumlahPenyewa = Penyewa::whereHas('transaksi', function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tgl_mulai', $bulan)
                ->whereYear('tgl_mulai', $tahun);
        })->count();

        $lakiLaki = 'Laki-laki';
        $perempuan = 'Perempuan';

        $jumlahLakilaki = Penyewa::whereHas('transaksi', function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tgl_mulai', $bulan)
                ->whereYear('tgl_mulai', $tahun)
                ->where('jenis_kelamin', 'Laki-laki');
        })->count();

        $jumlahPerempuan = Penyewa::whereHas('transaksi', function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tgl_mulai', $bulan)
                ->whereYear('tgl_mulai', $tahun)
                ->where('jenis_kelamin', 'Perempuan');
        })->count();


        $penyewas = Penyewa::withCount('transaksi')
            ->orWhere('nama_penyewa', 'like', '%' . $search . '%')
            ->orderByDesc('transaksi_count')
            ->paginate($paginate);
        return view('laporan.laporan-penyewa', [
            'title' => 'Laporan Penyewa',
            'active' => 'Laporan'
        ], compact(
            'penyewas',
            'bulan',
            'tahun',
            'jumlahPenyewa',
            'jumlahLakilaki',
            'jumlahPerempuan',
        ));
    }
}
