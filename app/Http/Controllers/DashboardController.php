<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pengeluaran;
use App\Models\Motor;
use App\Models\User;
use App\Models\Penyewa;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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

        // pendapatan&pengeluaran sesuai req
        $totalPendapatan = Transaksi::whereMonth('tgl_mulai', $bulan)->whereYear('tgl_mulai', $tahun)->sum('total');

        $totalPengeluaran = Pengeluaran::whereMonth('tgl_pengeluaran', $bulan)->whereYear('tgl_pengeluaran', $tahun)->sum('biaya_pengeluaran');

        $totalMotor = Motor::count();
        $totalPegawai = User::count();
        $totalPenyewa = Penyewa::whereHas('transaksi', function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tgl_mulai', $bulan)
                ->whereYear('tgl_mulai', $tahun);
        })->count();
        $totalPengeluaranMotor = Pengeluaran::whereMonth('tgl_pengeluaran', $bulan)->whereYear('tgl_pengeluaran', $tahun)->count();
        $totalTransaksi = Transaksi::whereMonth('tgl_mulai', $bulan)->whereYear('tgl_mulai', $tahun)->count();

        // Pendapatan per bulan berdasarkan tahun req
        $totalBulanJanuari = Transaksi::whereMonth('tgl_mulai', '=', '01')->whereYear('tgl_mulai', $tahun)->sum('total');
        $totalBulanFebruari = Transaksi::whereMonth('tgl_mulai', '=', '02')->whereYear('tgl_mulai', $tahun)->sum('total');
        $totalBulanMaret = Transaksi::whereMonth('tgl_mulai', '=', '03')->whereYear('tgl_mulai', $tahun)->sum('total');
        $totalBulanApril = Transaksi::whereMonth('tgl_mulai', '=', '04')->whereYear('tgl_mulai', $tahun)->sum('total');
        $totalBulanMei = Transaksi::whereMonth('tgl_mulai', '=', '05')->whereYear('tgl_mulai', $tahun)->sum('total');
        $totalBulanJuni = Transaksi::whereMonth('tgl_mulai', '=', '06')->whereYear('tgl_mulai', $tahun)->sum('total');
        $totalBulanJuli = Transaksi::whereMonth('tgl_mulai', '=', '07')->whereYear('tgl_mulai', $tahun)->sum('total');
        $totalBulanAgustus = Transaksi::whereMonth('tgl_mulai', '=', '08')->whereYear('tgl_mulai', $tahun)->sum('total');
        $totalBulanSeptember = Transaksi::whereMonth('tgl_mulai', '=', '09')->whereYear('tgl_mulai', $tahun)->sum('total');
        $totalBulanOktober = Transaksi::whereMonth('tgl_mulai', '=', '10')->whereYear('tgl_mulai', $tahun)->sum('total');
        $totalBulanNovember = Transaksi::whereMonth('tgl_mulai', '=', '11')->whereYear('tgl_mulai', $tahun)->sum('total');
        $totalBulanDesember = Transaksi::whereMonth('tgl_mulai', '=', '12')->whereYear('tgl_mulai', $tahun)->sum('total');
        return view('dashboard.index', [
            'title' => 'Dashboard',
            'active' => 'Dashboard'
        ], compact(
            [
                'totalPendapatan', 'totalPengeluaran', 'totalMotor', 'totalPegawai', 'totalPenyewa', 'totalPengeluaranMotor', 'totalTransaksi',
                'totalBulanJanuari',
                'totalBulanFebruari',
                'totalBulanMaret',
                'totalBulanApril',
                'totalBulanMei',
                'totalBulanJuni',
                'totalBulanJuli',
                'totalBulanAgustus',
                'totalBulanSeptember',
                'totalBulanOktober',
                'totalBulanNovember',
                'totalBulanDesember',
                'bulan',
                'tahun'
            ]
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
