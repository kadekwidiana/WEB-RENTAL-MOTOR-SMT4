<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use App\Models\Pengeluaran;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanMotorController extends Controller
{
    public function laporanMotor(Request $request)
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

        // pemasukan dan pengeluaran

        $totalPemasukan = Transaksi::whereMonth('tgl_mulai', $bulan)
            ->whereYear('tgl_mulai', $tahun)
            ->sum('total');

        $totalPengeluaran = Pengeluaran::whereMonth('tgl_pengeluaran', $bulan)
            ->whereYear('tgl_pengeluaran', $tahun)
            ->sum('biaya_pengeluaran');

        $jumlahTransaksi = Transaksi::whereMonth('tgl_mulai', $bulan)
            ->whereYear('tgl_mulai', $tahun)
            ->count();

        $motors = Motor::with(['transaksi', 'pengeluaran'])
            ->orWhere('nama_motor', 'like', '%' . $search . '%')
            ->orWhere('plat_motor', 'like', '%' . $search . '%')
            ->with(['transaksi' => function ($query) {
                $query->orderBy('updated_at', 'desc');
            }])
            ->paginate($paginate);

        return view('laporan.laporan-motor', [
            'title' => 'Laporan Motor',
            'active' => 'Laporan'
        ], compact(
            'motors',
            'bulan',
            'tahun',
            'totalPemasukan',
            'totalPengeluaran',
            'jumlahTransaksi'
        ));
    }

    public function detailLaporanMotor($plat_motor)
    {
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

        $motor = Motor::with(['transaksi' => function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tgl_mulai', $bulan)
                ->whereYear('tgl_mulai', $tahun);
        }, 'pengeluaran' => function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tgl_pengeluaran', $bulan)
                ->whereYear('tgl_pengeluaran', $tahun);
        }])->where('plat_motor', $plat_motor)->first();

        return view('laporan.detail-laporan-motor', [
            'title' => 'Detail Laporan Motor ' . $motor->nama_motor . '(' . $motor->plat_motor . ')',
            'active' => 'Laporan'
        ], compact(
            'motor',
            'bulan',
            'tahun',
        ));
    }
}
