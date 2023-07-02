@extends('layouts.main')

@section('content')

     {{-- filter/pencarian --}}
     <div class="row mb-2 mt-2">
        <div class="col">
            <form action="{{ route('transaksi.listPengembalian') }}" method="GET">
                <div class="input-group mb-3">
                <a href="{{ route('transaksi.listPengembalian') }}" class="btn btn-secondary"><i class="fas fa-retweet"></i></a>
                {{-- <input name="date" type="text" value="{{ request('date') }}" class="form-control" placeholder="Tanggal">     --}}
              <select name="month" id="month" class="form-select" required>
                <option value="">--Bulan--</option>
                <option value="01" {{ request('month') == '01' ? 'selected' : '' }}>Januari</option>
                <option value="02" {{ request('month') == '02' ? 'selected' : '' }}>Februari</option>
                <option value="03" {{ request('month') == '03' ? 'selected' : '' }}>Maret</option>
                <option value="04" {{ request('month') == '04' ? 'selected' : '' }}>April</option>
                <option value="05" {{ request('month') == '05' ? 'selected' : '' }}>Mei</option>
                <option value="06" {{ request('month') == '06' ? 'selected' : '' }}>Juni</option>
                <option value="07" {{ request('month') == '07' ? 'selected' : '' }}>Juli</option>
                <option value="08" {{ request('month') == '08' ? 'selected' : '' }}>Agustus</option>
                <option value="09" {{ request('month') == '09' ? 'selected' : '' }}>September</option>
                <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>Oktober</option>
                <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>November</option>
                <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>Desember</option>
              </select>
              <select name="year" id="year" class="form-select" required>
                <option value="">--Tahun--</option>
                <option value="2022" {{ request('year') == '2022' ? 'selected' : '' }}>2022</option>
                <option value="2023" {{ request('year') == '2023' ? 'selected' : '' }}>2023</option>
                <option value="2024" {{ request('year') == '2024' ? 'selected' : '' }}>2024</option>
                <option value="2025" {{ request('year') == '2025' ? 'selected' : '' }}>2025</option>
              </select>
              <button class="btn btn-secondary" type="submit" id="button-addon2"><i class="fas fa-filter"></i></button>
            </div>
          </form>
        </div>
        {{-- Pencarian pengeluaran --}}
        <div class="col-8">
          <form action="{{ route('transaksi.listPengembalian') }}" method="GET">
          <div class="input-group mb-3">
            <input name="search" type="text" value="{{ request('search') }}" class="form-control" placeholder="Cari...">
            <button class="btn btn-secondary" type="submit" id="button-addon2">Cari</button>
          </div>
        </form>
        </div>
      </div>

  {{-- PENGEMBALIAN --}}
  <table id="div1" class="table table-bordered">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Penyewa</th>
            <th>Motor</th>
            <th>Tgl Mulai</th>
            <th>Tgl Selesai</th>
            <th>Total Harga</th>
            <th>KM Awal</th>
            <th>KM Akhir</th>
            <th>Jumlah helm</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($transaksis as $transaksi)
        <tr>
            @if ($transaksi->status_transaksi == 0)
            <td>{{ $no++ }}</td>
            <td>{{ $transaksi->penyewa->nama_penyewa }}</td>
            <td>{{ $transaksi->motor->nama_motor }} {{ $transaksi->plat_motor }}</td>
            <td>{{ date('d F Y', strtotime($transaksi->tgl_mulai)) }}</td>
            <td>{{ date('d F Y', strtotime($transaksi->tgl_selesai)) }}</td>
            <td>{{ number_format($transaksi->total, 0, ',', '.') }}</td>
            <td>{{ number_format($transaksi->km_awal, 0, ',', '.') }}</td>
            <td>{{ $transaksi->km_akhir }}</td>
            <td>{{ $transaksi->jumlah_helm }}</td>

            <td>
                <a href="{{ route('transaksi.pengembalian', $transaksi->kode_transaksi) }}" class="btn btn-warning btn-sm mt-1" >Pengembalian</a>

                <button type="button" class="btn btn-info btn-sm mt-1" data-bs-toggle="modal" data-bs-target="#{{ $transaksi->kode_transaksi }}">
                  Detail
                </button>
                
            </td>
            @endif
        </tr>
          <!-- Modal Detail Transaksi -->
        <div class="modal fade" id="{{ $transaksi->kode_transaksi }}" tabindex="-1" aria-labelledby="{{ $transaksi->kode_transaksi }}Label" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title fw-bold" id="exampleModalLabel">Detail Transaksi</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p><strong>Kode Transaksi     : </strong>{{ $transaksi->kode_transaksi }}</p>
                <p><strong>Nama Penyewa       : </strong>{{ $transaksi->penyewa->nama_penyewa }}  <strong> No Paspor : </strong>{{ $transaksi->no_paspor }} </p>
                <p><strong>Motor yang di sewa : </strong>{{ $transaksi->motor->nama_motor }} {{ $transaksi->plat_motor }}</p>
                <p><strong>Operator/Pegawai   : </strong>{{ $transaksi->user->nama_pegawai }} </p>
                <p><strong>Tanggal mulai      : </strong>{{ $transaksi->tgl_mulai }}</p>
                <p><strong>Tanggal selesai    : </strong>{{ $transaksi->tgl_selesai }}</p>
                <p><strong>Total harga sewa   : </strong>Rp.{{ number_format($transaksi->total, 0, ',', '.') }}</p>
                <p><strong>Kilometer Awal     : </strong>{{ number_format($transaksi->km_awal, 0, ',', '.') }} km.</p>
                <p><strong>Kilometer Akhir    : </strong>{{ $transaksi->km_akhir }}</p>
                <p><strong>Catatan            : </strong>{{ $transaksi->catatan }}</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        @endforeach
    </tbody>
  </table>

  <div class="d-flex justify-content-end mt-2">
    {{ $transaksis->links() }}
  </div>

  @empty($transaksi)
    <div class="text-center" style="font-weight: bold">
      <h5 style="font-weight: bold">Data Transaksi tidak ada</h5>
      <a href="{{ route('transaksi.create') }}" class="">Tambah ?</a>
    </div>
  @endempty

  
@endsection
