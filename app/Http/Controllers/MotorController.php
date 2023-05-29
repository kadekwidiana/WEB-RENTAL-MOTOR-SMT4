<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Pengeluaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\Console\Input\Input;

class MotorController extends Controller
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
            $paginate = 100;
        } else {
            $paginate = 10;
        }

        $query = Motor::query();

        if ($search) {
            $query->where('nama_motor', 'like', '%' . $search . '%')
                ->orWhere('plat_motor', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%')
                ->orWhere('tipe', 'like', '%' . $search . '%')
                ->orWhere('tgl_catat', 'like', '%' . $search . '%');
        }

        if ($filter) {
            $query->where('status', 'like', '%' . $filter . '%')
                ->orWhere('tipe', 'like', '%' . $filter . '%');
        }

        $motors = $query->latest()->paginate($paginate);

        return view('motor.index', [
            'title' => 'Data Motor',
            'active' => 'Motor'
        ], compact('motors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('motor.create', [
            'title' => 'Tambah Data Motor',
            'active' => 'Motor'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'plat_motor' => 'required|string|max:15|unique:motors',
            'nama_motor' => 'required|string|max:20',
            'warna' => 'required|in:merah,kuning,hijau,biru,hitam,putih',
            'tipe' => 'required',
            'tahun' => 'required|numeric|digits:4',
            'tgl_pajak' => 'required|date',
            'nama_pemilik' => 'required|string|max:100',
            'cc' => 'required|numeric|digits:3',
            'harga_sewa' => 'required|string|max:10',
            'status' => 'required|numeric|digits:1',
            'gambar_motor' => 'required',
            'tgl_catat' => 'required|date'
        ]);

        if ($request->file('gambar_motor')) {
            $data['gambar_motor'] = $request->file('gambar_motor')->store('motors-image');
        }

        Motor::create($data);

        return redirect()->route('motor.index')->with('success', 'Data berhasil ditambahkan');
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
    public function edit($plat_motor)
    {
        $motor = Motor::findOrFail($plat_motor);
        return view(
            'motor.edit',
            [
                'title' => 'Edit data motor',
                'active' => 'Motor'
            ],
            compact('motor')
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $plat_motor)
    {
        $validatedData = $request->validate([
            'nama_motor' => 'required|string|max:20',
            'warna' => 'required|string|max:10',
            'tipe' => 'required|string|max:10',
            'tahun' => 'required|numeric|digits:4',
            'tgl_pajak' => 'required|date',
            'nama_pemilik' => 'required|string|max:100',
            'cc' => 'required|numeric|digits:3',
            'harga_sewa' => 'required|string|max:10',
            'status' => 'required|numeric|digits:1',
            // 'gambar_motor' => 'required',
            'tgl_catat' => 'required|date'
        ]);

        if ($request->file('gambar_motor')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['gambar_motor'] = $request->file('gambar_motor')->store('motors-image');
        }

        $motor = Motor::findOrFail($plat_motor);
        $motor->update($validatedData);

        return redirect()->route('motor.index')->with('success', 'Motor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($plat_motor)
    {
        $motor = Motor::findOrFail($plat_motor);

        // Menghapus transaksi jika data motor yang ingin di hapus ada di transaksi
        $transaksi = Transaksi::where('plat_motor', $plat_motor)->first(); // mencari data transaksi berdasarkan plat_motor
        if ($transaksi) {
            $transaksi->delete();

            $transaksi->delete(); // menghapus data transaksi
        }

        // Menghapus transaksi jika data motor yang ingin di hapus ada di transaksi
        $pengeluaran = Pengeluaran::where('plat_motor', $plat_motor)->first(); // mencari data pengeluaran berdasarkan plat_motor
        if ($pengeluaran) {
            $pengeluaran->delete();

            $pengeluaran->delete(); // menghapus data pengeluaran
        }

        if ($motor->gambar_motor) {
            Storage::delete($motor->gambar_motor);
        }
        $motor->delete();

        return redirect()->route('motor.index')->with('success', 'Motor deleted successfully.');
    }
}
