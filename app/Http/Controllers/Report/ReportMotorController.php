<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use App\Models\Transaksi;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class ReportMotorController extends Controller
{
    public function reportMotor(Request $request)
    {
        $search = $request->search;
        $filter = $request->input('filter');
        $month = $request->input('month');
        $year = $request->input('year');

        if ($search | $filter | $month | $year) {
            $paginate = 100;
        } else {
            $paginate = 10;
        }

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

        $motors = $query->leftJoin('transaksis', 'motors.plat_motor', '=', 'transaksis.plat_motor')
            ->leftJoin('pengeluarans', 'motors.plat_motor', '=', 'pengeluarans.plat_motor')
            ->select('motors.*', 'transaksis.tgl_selesai', 'pengeluarans.tgl_pengeluaran')
            ->where(function ($q) {
                $q->whereNotNull('transaksis.tgl_selesai')
                    ->orWhereNotNull('pengeluarans.tgl_pengeluaran');
            })
            ->latest('transaksis.tgl_mulai')
            ->paginate($paginate);


        // $motors = Motor::with(['transaksi', 'pengeluaran'])
        //     ->orWhere('nama_motor', 'like', '%' . $search . '%')
        //     ->latest()
        //     ->paginate(10);

        return view('dashboard.report.motor', [
            'title' => 'Laporan Motor',
            'active' => 'Dashboard'
        ], compact('motors'));
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
