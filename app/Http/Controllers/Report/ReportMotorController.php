<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use App\Models\Transaksi;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportMotorController extends Controller
{
    public function reportMotor(Request $request)
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

        $totalPemasukan = Transaksi::where('status_transaksi', 1)
            ->whereMonth('tgl_selesai', $bulan)
            ->whereYear('tgl_selesai', $tahun)
            ->sum('total');

        $totalPengeluaran = Pengeluaran::whereMonth('tgl_pengeluaran', $bulan)
            ->whereYear('tgl_pengeluaran', $tahun)
            ->sum('biaya_pengeluaran');

        $jumlahTransaksi = Transaksi::where('status_transaksi', 1)
            ->whereMonth('tgl_selesai', $bulan)
            ->whereYear('tgl_selesai', $tahun)
            ->count();

        $motors = Motor::with(['transaksi', 'pengeluaran'])
            ->orWhere('nama_motor', 'like', '%' . $search . '%')
            ->orWhere('plat_motor', 'like', '%' . $search . '%')
            ->with(['transaksi' => function ($query) {
                $query->orderBy('updated_at', 'desc');
            }])
            ->paginate($paginate);

        return view('dashboard.report.motor', [
            'title' => 'Laporan Motor',
            'active' => 'Dashboard'
        ], compact(
            'motors',
            'bulan',
            'tahun',
            'totalPemasukan',
            'totalPengeluaran',
            'jumlahTransaksi'
        ));
    }

    public function detailReportMotor($plat_motor)
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
            $query->whereMonth('tgl_selesai', $bulan)
                ->whereYear('tgl_selesai', $tahun);
        }, 'pengeluaran' => function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tgl_pengeluaran', $bulan)
                ->whereYear('tgl_pengeluaran', $tahun);
        }])->where('plat_motor', $plat_motor)->first();

        return view('dashboard.report.detail-report-motor', [
            'title' => 'Detail Laporan Motor ' . $motor->nama_motor . '(' . $motor->plat_motor . ')',
            'active' => 'Dashboard'
        ], compact(
            'motor',
            'bulan',
            'tahun',
        ));
    }
}
