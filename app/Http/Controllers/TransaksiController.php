<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Motor;
use App\Models\Pegawai;
use App\Models\Penyewa;
use App\Models\User;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $totalTransaksi = Transaksi::sum('total');
        $search = $request->search;
        $transaksis = Transaksi::with('motor', 'penyewa', 'user')
            ->orWhere('kode_transaksi', 'like', '%' . $search . '%')
            ->orWhere('plat_motor', 'like', '%' . $search . '%')
            ->orWhere(function ($query) use ($search) {
                $query->where('plat_motor', 'like', '%' . $search . '%')
                    ->orWhereHas('motor', function ($query) use ($search) {
                        $query->where('nama_motor', 'like', '%' . $search . '%');
                    });
            })
            ->orWhere(function ($query) use ($search) {
                $query->where('no_paspor', 'like', '%' . $search . '%')
                    ->orWhereHas('penyewa', function ($query) use ($search) {
                        $query->where('nama_penyewa', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->paginate(10);
        return view('transaksi.index', [
            'title' => 'Data Transaksi',
            'active' => 'Transaksi'
        ], compact('transaksis', 'totalTransaksi'));
    }

    // VIEW PENYEWAAN
    public function penyewaan(Request $request)
    {
        $search = $request->search;
        $date = $request->input('date');
        $month = $request->input('month');
        $year = $request->input('year');

        $query = Transaksi::query();

        if ($search) {
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('plat_motor', 'like', '%' . $search . '%')
                    ->orWhereHas('motor', function ($q) use ($search) {
                        $q->where('nama_motor', 'like', '%' . $search . '%');
                    })
                    ->orWhere(function ($query) use ($search) {
                        $query->where('no_paspor', 'like', '%' . $search . '%')
                            ->orWhereHas('penyewa', function ($query) use ($search) {
                                $query->where('nama_penyewa', 'like', '%' . $search . '%');
                            });
                    });
            });
        }

        if ($date) {
            $query->where(function ($innerQuery) use ($date) {
                $innerQuery->whereDate('tgl_mulai', $date);
            });
        }
        if ($month) {
            $query->where(function ($innerQuery) use ($month) {
                // $innerQuery->where('tgl_pengeluaran', 'like', '%' . $month . '%');
                $innerQuery->whereMonth('tgl_mulai', $month);
            });
        }
        if ($year) {
            $query->where(function ($innerQuery) use ($year) {
                $innerQuery->whereYear('tgl_mulai', $year);
            });
        }

        $transaksis = $query->latest()->paginate(10);

        return view('transaksi.list.penyewaan', [
            'title' => 'Data Penyewaan',
            'active' => 'Transaksi'
        ], compact('transaksis'));
    }

    // VIEW PENGEMBALIAN
    public function listPengembalian(Request $request)
    {
        $search = $request->search;
        $date = $request->input('date');
        $month = $request->input('month');
        $year = $request->input('year');

        $query = Transaksi::query();

        if ($search) {
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('plat_motor', 'like', '%' . $search . '%')
                    ->orWhereHas('motor', function ($q) use ($search) {
                        $q->where('nama_motor', 'like', '%' . $search . '%');
                    })
                    ->orWhere(function ($query) use ($search) {
                        $query->where('no_paspor', 'like', '%' . $search . '%')
                            ->orWhereHas('penyewa', function ($query) use ($search) {
                                $query->where('nama_penyewa', 'like', '%' . $search . '%');
                            });
                    });
            });
        }

        if ($date) {
            $query->where(function ($innerQuery) use ($date) {
                $innerQuery->whereDate('tgl_mulai', $date);
            });
        }
        if ($month) {
            $query->where(function ($innerQuery) use ($month) {
                // $innerQuery->where('tgl_pengeluaran', 'like', '%' . $month . '%');
                $innerQuery->whereMonth('tgl_mulai', $month);
            });
        }
        if ($year) {
            $query->where(function ($innerQuery) use ($year) {
                $innerQuery->whereYear('tgl_mulai', $year);
            });
        }

        $transaksis = $query->latest()->paginate(10);

        return view('transaksi.list.pengembalian', [
            'title' => 'Pengembalian',
            'active' => 'Transaksi'
        ], compact('transaksis'));
    }

    // VIEW RIWAYAT TRANSAKSI
    public function listRiwayatTransaksi(Request $request)
    {
        $search = $request->search;
        $date = $request->input('date');
        $month = $request->input('month');
        $year = $request->input('year');

        $query = Transaksi::query();

        if ($search) {
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('plat_motor', 'like', '%' . $search . '%')
                    ->orWhereHas('motor', function ($q) use ($search) {
                        $q->where('nama_motor', 'like', '%' . $search . '%');
                    })
                    ->orWhere(function ($query) use ($search) {
                        $query->where('no_paspor', 'like', '%' . $search . '%')
                            ->orWhereHas('penyewa', function ($query) use ($search) {
                                $query->where('nama_penyewa', 'like', '%' . $search . '%');
                            });
                    });
            });
        }

        if ($date) {
            $query->where(function ($innerQuery) use ($date) {
                $innerQuery->whereDate('tgl_mulai', $date);
            });
        }
        if ($month) {
            $query->where(function ($innerQuery) use ($month) {
                // $innerQuery->where('tgl_pengeluaran', 'like', '%' . $month . '%');
                $innerQuery->whereMonth('tgl_mulai', $month);
            });
        }
        if ($year) {
            $query->where(function ($innerQuery) use ($year) {
                $innerQuery->whereYear('tgl_mulai', $year);
            });
        }

        $transaksis = $query->latest()->paginate(10);

        return view('transaksi.list.riwayat-transaksi', [
            'title' => 'Riwayat Transaksi',
            'active' => 'Transaksi'
        ], compact('transaksis'));
    }

    public function create()
    {
        $transaksi = new Transaksi();
        $motors = Motor::all();
        // $penyewas = Penyewa::all();
        $users = User::all();
        return view('transaksi.create', [
            'title' => 'Tambah Transaksi',
            'active' => 'Transaksi',
        ], compact('transaksi', 'motors', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // penyewa
            'no_paspor' => 'required|unique:transaksis,no_paspor|max:15',
            'nama_penyewa' => 'required',
            'email' => 'required',
            'asal_negara' => 'required',
            'jenis_kelamin' => 'required',
            'domisili' => 'required',
            'no_telepon' => 'required|numeric',
            'no_sim' => 'required',
            // transaksi
            'kode_transaksi' => 'required|unique:transaksis,kode_transaksi|max:15',
            'plat_motor' => 'required',
            'no_paspor' => 'required',
            'id_pegawai' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'total' => 'required|numeric',
            'km_awal' => 'required|numeric',
            'km_akhir' => 'required',
            'jumlah_helm' => 'required|numeric',
            'catatan' => 'required',
        ]);

        $penyewa = new Penyewa();
        $penyewa->no_paspor = $validated['no_paspor'];
        $penyewa->nama_penyewa = $validated['nama_penyewa'];
        $penyewa->email = $validated['email'];
        $penyewa->asal_negara = $validated['asal_negara'];
        $penyewa->jenis_kelamin = $validated['jenis_kelamin'];
        $penyewa->domisili = $validated['domisili'];
        $penyewa->no_telepon = $validated['no_telepon'];
        $penyewa->no_sim = $validated['no_sim'];
        $penyewa->save();

        $transaksi = new Transaksi();
        $transaksi->kode_transaksi = $validated['kode_transaksi'];
        $transaksi->plat_motor = $validated['plat_motor'];
        // $transaksi->no_paspor = $penyewa->no_paspor;
        $transaksi->no_paspor = $validated['no_paspor'];
        $transaksi->id_pegawai = $validated['id_pegawai'];
        $transaksi->tgl_mulai = $validated['tgl_mulai'];
        $transaksi->tgl_selesai = $validated['tgl_selesai'];
        $transaksi->total = $validated['total'];
        $transaksi->km_awal = $validated['km_awal'];
        $transaksi->km_akhir = $validated['km_akhir'];
        $transaksi->catatan = $validated['catatan'];
        $transaksi->jumlah_helm = $validated['jumlah_helm'];
        $transaksi->status_transaksi = 0;
        $transaksi->save();

        // memperbarui status motor
        $motor = Motor::where('plat_motor', $request->input('plat_motor'))->firstOrFail();
        $motor->status = 0;
        $motor->save();

        // Transaksi::create($request->all());

        return redirect()->route('transaksi.penyewaan')
            ->with('success', 'Transaksi berhasil di buat.');
    }

    public function show($kode_transaksi)
    {
        $transaksi = Transaksi::with('motor', 'penyewa', 'user')->where('kode_transaksi', $kode_transaksi)->first();
        return view('transaksi.show', [
            'title' => 'Detail Transaksi',
            'active' => 'Transaksi'
        ], compact('transaksi'));
    }

    // input transaksi jika data penyewa sudah ada
    public function viewadd()
    {
        $motors = Motor::all();
        $penyewas = Penyewa::all();
        $users = User::all();
        return view('transaksi.tambah', [
            'title' => 'Tambah Transaksi',
            'active' => 'Transaksi'
        ], compact('motors', 'penyewas', 'users'));
    }

    // mengolah tambah data penyewa yang sudah ada
    public function tambah(Request $request)
    {
        $validated = $request->validate([
            // transaksi
            'kode_transaksi' => 'required|unique:transaksis,kode_transaksi|max:15',
            'plat_motor' => 'required',
            'no_paspor' => 'required',
            'id_pegawai' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'total' => 'required|numeric',
            'km_awal' => 'required|numeric',
            'km_akhir' => 'required',
            'jumlah_helm' => 'required|numeric',
            'catatan' => 'required'
        ]);

        $transaksi = new Transaksi();
        $transaksi->kode_transaksi = $validated['kode_transaksi'];
        $transaksi->plat_motor = $validated['plat_motor'];
        $transaksi->no_paspor = $validated['no_paspor'];
        $transaksi->id_pegawai = $validated['id_pegawai'];
        $transaksi->tgl_mulai = $validated['tgl_mulai'];
        $transaksi->tgl_selesai = $validated['tgl_selesai'];
        $transaksi->total = $validated['total'];
        $transaksi->km_awal = $validated['km_awal'];
        $transaksi->km_akhir = $validated['km_akhir'];
        $transaksi->catatan = $validated['catatan'];
        $transaksi->jumlah_helm = $validated['jumlah_helm'];
        $transaksi->status_transaksi = 0;
        $transaksi->save();

        // memperbarui status motor
        $motor = Motor::where('plat_motor', $request->input('plat_motor'))->firstOrFail();
        $motor->status = 0;
        $motor->save();

        return redirect()->route('transaksi.penyewaan')
            ->with('success', 'Transaksi berhasil di buat.');
    }


    // mengolah data pengembalian
    public function pengembalian(Request $request, $kode_transaksi)
    {
        $validated = $request->validate([
            // penyewa
            'no_paspor' => 'required',
            'nama_penyewa' => 'required',
            'email' => 'required',
            'asal_negara' => 'required',
            'jenis_kelamin' => 'required',
            'domisili' => 'required',
            'no_telepon' => 'required|numeric',
            'no_sim' => 'required',
            // transaksi
            'kode_transaksi' => 'required',
            'plat_motor' => 'required',
            'no_paspor' => 'required',
            'id_pegawai' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'total' => 'required',
            'km_awal' => 'required|numeric',
            'km_akhir' => 'required',
            'jumlah_helm' => 'required|numeric',
            'catatan' => 'required'
        ]);

        $penyewa = Penyewa::where('no_paspor', $validated['no_paspor'])->firstOrFail();
        $penyewa->no_paspor = $validated['no_paspor'];
        $penyewa->nama_penyewa = $validated['nama_penyewa'];
        $penyewa->email = $validated['email'];
        $penyewa->asal_negara = $validated['asal_negara'];
        $penyewa->jenis_kelamin = $validated['jenis_kelamin'];
        $penyewa->domisili = $validated['domisili'];
        $penyewa->no_telepon = $validated['no_telepon'];
        $penyewa->no_sim = $validated['no_sim'];
        $penyewa->update();

        // $transaksi = Transaksi::findOrFail($kode_transaksi);

        $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->first();
        // $transaksi->kode_transaksi = $validated['kode_transaksi'];
        $transaksi->plat_motor = $validated['plat_motor'];
        // $transaksi->no_paspor = $penyewa->no_paspor;
        $transaksi->no_paspor = $validated['no_paspor'];
        $transaksi->id_pegawai = $validated['id_pegawai'];
        $transaksi->tgl_mulai = $validated['tgl_mulai'];
        $transaksi->tgl_selesai = $validated['tgl_selesai'];
        $transaksi->total = $validated['total'];
        $transaksi->km_awal = $validated['km_awal'];
        $transaksi->km_akhir = $validated['km_akhir'];
        $transaksi->catatan = $validated['catatan'];
        $transaksi->jumlah_helm = $validated['jumlah_helm'];
        $transaksi->status_transaksi = 1;
        $transaksi->update();

        // memperbarui status motor
        $motor = Motor::where('plat_motor', $request->input('plat_motor'))->firstOrFail();
        $motor->status = 1;
        $motor->save();

        // $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->first();
        // $transaksi->update($request->all());

        return redirect()->route('transaksi.listPengembalian')
            ->with('success', 'Transaksi Pengembalian motor berhasil. Silahkan cek di riwayat transaksi!');
    }

    // menampilkan view pengembalian
    public function pengembalianForm($kode_transaksi)
    {
        $transaksi = Transaksi::with('motor', 'penyewa', 'user')->where('kode_transaksi', $kode_transaksi)->first();
        $motors = Motor::all();
        $penyewas = Penyewa::all();
        $users = User::all();
        return view('transaksi.pengembalian', [
            'title' => 'Pengembalian',
            'active' => 'Transaksi'
        ], compact('transaksi', 'motors', 'penyewas', 'users'));
    }

    public function edit($kode_transaksi)
    {
        $transaksi = Transaksi::with('motor', 'penyewa', 'user')->where('kode_transaksi', $kode_transaksi)->first();
        $motors = Motor::all();
        $penyewas = Penyewa::all();
        $users = User::all();
        return view('transaksi.edit', [
            'title' => 'Edit Transaksi',
            'active' => 'Transaksi'
        ], compact('transaksi', 'motors', 'penyewas', 'users'));
    }

    public function update(Request $request, $kode_transaksi)
    {
        $validated = $request->validate([
            // penyewa
            'no_paspor' => 'required',
            'nama_penyewa' => 'required',
            'email' => 'required',
            'asal_negara' => 'required',
            'jenis_kelamin' => 'required',
            'domisili' => 'required',
            'no_telepon' => 'required|numeric',
            'no_sim' => 'required',
            // transaksi
            'kode_transaksi' => 'required',
            'plat_motor' => 'required',
            'no_paspor' => 'required',
            'id_pegawai' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'total' => 'required|numeric',
            'km_awal' => 'required|numeric',
            'km_akhir' => 'required',
            'jumlah_helm' => 'required|numeric',
            'catatan' => 'required',
        ]);

        $penyewa = Penyewa::where('no_paspor', $validated['no_paspor'])->firstOrFail();
        $penyewa->no_paspor = $validated['no_paspor'];
        $penyewa->nama_penyewa = $validated['nama_penyewa'];
        $penyewa->email = $validated['email'];
        $penyewa->asal_negara = $validated['asal_negara'];
        $penyewa->jenis_kelamin = $validated['jenis_kelamin'];
        $penyewa->domisili = $validated['domisili'];
        $penyewa->no_telepon = $validated['no_telepon'];
        $penyewa->no_sim = $validated['no_sim'];
        $penyewa->update();

        // $transaksi = Transaksi::findOrFail($kode_transaksi);

        $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->first();
        // $transaksi->kode_transaksi = $validated['kode_transaksi'];
        $transaksi->plat_motor = $validated['plat_motor'];
        // $transaksi->no_paspor = $penyewa->no_paspor;
        $transaksi->no_paspor = $validated['no_paspor'];
        $transaksi->id_pegawai = $validated['id_pegawai'];
        $transaksi->tgl_mulai = $validated['tgl_mulai'];
        $transaksi->tgl_selesai = $validated['tgl_selesai'];
        $transaksi->total = $validated['total'];
        $transaksi->km_awal = $validated['km_awal'];
        $transaksi->km_akhir = $validated['km_akhir'];
        $transaksi->catatan = $validated['catatan'];
        $transaksi->jumlah_helm = $validated['jumlah_helm'];
        $transaksi->status_transaksi = 0;
        $transaksi->update();
        // $transaksi->update($request->all());

        return redirect()->route('transaksi.penyewaan')
            ->with('success', 'Transaksi berhasil di edit.');
    }

    public function destroy($kode_transaksi)
    {
        $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->first();

        // ubah status motor
        $motor = Motor::findOrFail($transaksi->plat_motor);
        $motor->status = 1;
        $motor->save();

        $transaksi->delete();

        return redirect()->route('transaksi.penyewaan')
            ->with('success', 'Transaksi berhasil di hapus.');
    }
}
