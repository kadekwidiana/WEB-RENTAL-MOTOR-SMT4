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

        if ($search) {
            $paginate = 100;
        } else {
            $paginate = 10;
        }

        $query = Motor::query();
        if ($search) {
            $query->where('nama_motor', 'like', '%' . $search . '%')
                ->orWhere('plat_motor', 'like', '%' . $search . '%');
        }

        $motors = $query->latest()->paginate($paginate);

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
