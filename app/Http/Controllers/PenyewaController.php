<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewa;

use App\Models\Motor;
use App\Models\Transaksi;
use App\Http\Controllers\TransaksiController;

class PenyewaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->filter;
        $search = $request->search;

        if ($search || $filter) {
            $paginate = 50;
        } else {
            $paginate = 10;
        }

        $query = Penyewa::query();

        if ($search) {
            $query->where('no_paspor', 'like', '%' . $search . '%')
                ->orWhere('nama_penyewa', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('asal_negara', 'like', '%' . $search . '%')
                ->orWhere('jenis_kelamin', 'like', '%' . $search . '%')
                ->orWhere('domisili', 'like', '%' . $search . '%');
        }

        if ($filter) {
            $query->where('jenis_kelamin', 'like', '%' . $filter . '%');
        }

        $penyewas = $query->latest()->paginate($paginate);

        return view('penyewa.index', [
            'title' => 'Data Penyewa',
            'active' => 'Penyewa'
        ], compact('penyewas'));
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
        $penyewa = Penyewa::findOrFail($id);
        
        return view('penyewa.edit', [
            'title' => 'Edit Data Penyewa',
            'active' => 'Penyewa'
        ], compact('penyewa'));
    }
/**
 * Memperbarui data penyewa yang sudah ada.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  string  $penyewa
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, $penyewa)
{
    $request->validate([
        'nama_penyewa' => 'required',
        'email' => 'required|email',
        'jenis_kelamin' => 'required',
        'domisili' => 'required',
        'no_telepon' => 'required',
    ]);

    $penyewaData = Penyewa::find($penyewa);

    if (!$penyewaData) {
        return redirect()->route('penyewa.index')->with('error', 'Data penyewa tidak ditemukan.');
    }

    $penyewaData->nama_penyewa = $request->nama_penyewa;
    $penyewaData->email = $request->email;
    $penyewaData->jenis_kelamin = $request->jenis_kelamin;
    $penyewaData->domisili = $request->domisili;
    $penyewaData->no_telepon = $request->no_telepon;
    $penyewaData->no_sim = $request->no_sim;
    $penyewaData->save();

    return redirect()->route('penyewa.index')->with('success', 'Data penyewa berhasil diperbarui.');
}
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($no_paspor)
    {
        $penyewa = Penyewa::find($no_paspor); // mencari data penyewa yang akan dihapus
        if (!$penyewa) {
            return redirect()->route('penyewa.index')->with('error', 'Data penyewa tidak ditemukan.'); // redirect ke halaman index dengan pesan error jika data tidak ditemukan

        }

        $transaksi = Transaksi::where('no_paspor', $no_paspor)->first(); // mencari data transaksi berdasarkan no_paspor
        if ($transaksi) {
            $transaksi->delete();
            // menghapus data transaksi
            // ubah status motor
            $motor = Motor::findOrFail($transaksi->plat_motor);
            $motor->status = 1;
            $motor->save();
        }



        $penyewa->delete(); // menghapus data penyewa dari database
        return redirect()->route('penyewa.index')->with('success', 'Data penyewa berhasil dihapus.'); // redirect ke halaman index dengan pesan sukses

    }
}
