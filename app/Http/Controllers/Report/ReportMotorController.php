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
        $filter = $request->input('filter');
        $month = $request->input('month');
        $year = $request->input('year');



        $query = Motor::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('motors.nama_motor', 'like', '%' . $search . '%')
                    ->orWhere('transaksis.plat_motor', 'like', '%' . $search . '%');
            });
        }

        if ($filter) {
            $query->where(function ($innerQuery) use ($filter) {
                $innerQuery->where('plat_motor', 'like', '%' . $filter . '%')
                    ->orWhereHas('motor', function ($q) use ($filter) {
                        $q->where('nama_motor', 'like', '%' . $filter . '%');
                    });
            });
        }
        if ($month) {
            $query->where(function ($innerQuery) use ($month) {
                // $innerQuery->where('tgl_pengeluaran', 'like', '%' . $month . '%');
                $innerQuery->whereMonth('transaksis.tgl_selesai', $month)
                    ->orWhereMonth('pengeluarans.tgl_pengeluaran', $month);
            });
        }
        if ($year) {
            $query->where(function ($innerQuery) use ($year) {
                $innerQuery->whereYear('transaksis.tgl_selesai', $year)
                    ->orWhereYear('pengeluarans.tgl_pengeluaran', $year);
            });
        }

        $currentMonth = Carbon::now()->format('Y-m');

        // $motors = $query->leftJoin(
        //     DB::raw('(SELECT plat_motor, MAX(tgl_selesai) AS max_selesai FROM transaksis WHERE DATE_FORMAT(tgl_selesai, "%Y-%m") = "' . $currentMonth . '" GROUP BY plat_motor) AS max_transaksis'),
        //     function ($join) {
        //         $join->on('motors.plat_motor', '=', 'max_transaksis.plat_motor');
        //     }
        // )
        //     ->leftJoin(
        //         DB::raw('(SELECT plat_motor, MAX(tgl_pengeluaran) AS max_pengeluaran FROM pengeluarans WHERE DATE_FORMAT(tgl_pengeluaran, "%Y-%m") = "' . $currentMonth . '" GROUP BY plat_motor) AS max_pengeluarans'),
        //         function ($join) {
        //             $join->on('motors.plat_motor', '=', 'max_pengeluarans.plat_motor');
        //         }
        //     )
        //     ->select('motors.*', 'max_transaksis.max_selesai', 'max_pengeluarans.max_pengeluaran')
        //     ->where(function ($q) use ($currentMonth) {
        //         $q->where(function ($query) use ($currentMonth) {
        //             $query->whereNotNull('max_transaksis.max_selesai')
        //                 ->orWhereNotNull('max_pengeluarans.max_pengeluaran');
        //         })
        //             ->orWhereNotExists(function ($query) use ($currentMonth) {
        //                 $query->select(DB::raw(1))
        //                     ->from('motors')
        //                     ->leftJoin('transaksis', function ($join) {
        //                         $join->on('motors.plat_motor', '=', 'transaksis.plat_motor');
        //                     })
        //                     ->leftJoin('pengeluarans', function ($join) {
        //                         $join->on('motors.plat_motor', '=', 'pengeluarans.plat_motor');
        //                     })
        //                     ->whereRaw('motors.plat_motor = motors.plat_motor')
        //                     ->where(function ($q) use ($currentMonth) {
        //                         $q->whereNull('transaksis.tgl_selesai')
        //                             ->whereNull('pengeluarans.tgl_pengeluaran')
        //                             ->orWhere(function ($q) use ($currentMonth) {
        //                                 $q->whereNotNull('transaksis.tgl_selesai')
        //                                     ->where('transaksis.tgl_selesai', '<>', $currentMonth)
        //                                     ->orWhereNotNull('pengeluarans.tgl_pengeluaran')
        //                                     ->where('pengeluarans.tgl_pengeluaran', '<>', $currentMonth);
        //                             });
        //                     });
        //             });
        //     })
        //     ->latest('max_transaksis.max_selesai')
        //     ->paginate($paginate);


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
        ));
    }

    public function detailReportMotor($plat_motor)
    {
        $motor = Motor::with(['transaksi', 'pengeluaran'])->where('plat_motor', $plat_motor)->first();

        return view('dashboard.report.detail-report-motor', [
            'title' => 'Detail Laporan Motor',
            'active' => 'Dashboard'
        ], compact('motor'));
    }
}
