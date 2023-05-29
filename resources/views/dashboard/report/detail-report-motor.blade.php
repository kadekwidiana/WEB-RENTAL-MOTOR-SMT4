@extends('layouts.main')

@section('content')
<div class="container">
    <dl class="row">
        <dt class="col-sm-3">Gambar Motor</dt>
        <dd class="col-sm-9"> 
            <img src="{{ asset('storage/' . $motor->gambar_motor) }}" width="150" alt="">
        </dd>

        <dt class="col-sm-3">Merek Motor</dt>
        <dd class="col-sm-9">: {{ $motor->nama_motor }} {{ $motor->cc }} cc.  ({{ $motor->plat_motor }})</dd>

        <dt class="col-sm-3">Nama Pemilik</dt>
        <dd class="col-sm-9">: {{ $motor->nama_pemilik }}</dd>
      
        <hr class="divider" />
        <dt class="col-sm-3">Pemasukan</dt>
        <dd class="col-sm-9">: Rp. 
            @php
                $pemasukan = $motor->transaksi->sum('total');
                echo number_format($pemasukan, 0, ',', '.')
            @endphp
        </dd>

        <dt class="col-sm-3">Tanggal Pemasukan</dt>
        <dd class="col-sm-9">:  
            @foreach ($motor->transaksi as $data)
                {{ date('d F Y', strtotime($data->tgl_selesai)) }}, 
            @endforeach
        </dd>

        <dt class="col-sm-3">Daftar Penyewa</dt>
        <dd class="col-sm-9"> :
            @foreach ($motor->transaksi as $data)
                {{ $data->penyewa->nama_penyewa }}, 
            @endforeach
        </dd>

        <hr class="divider" />
        <dt class="col-sm-3">Tgl dan Jenis Pengeluaran</dt>
        <dd class="col-sm-9">:  
            @foreach ($motor->pengeluaran as $data)
                {{ date('d F Y', strtotime($data->tgl_pengeluaran)) }} {{ $data->jenis_pengeluaran }}, 
            @endforeach
        </dd>

        <dt class="col-sm-3">Biaya Pengeluaran</dt>
        <dd class="col-sm-9">: Rp. 
            @php
                $pengeluaran = $motor->pengeluaran->sum('biaya_pengeluaran');
                echo number_format($pengeluaran, 0, ',', '.')
            @endphp
        </dd>

        <hr class="divider" />
        <dt class="col-sm-3">Total Penghasilan</dt>
        <dd class="col-sm-9">: Rp. {{ number_format($pemasukan - $pengeluaran, 0, ',', '.') }}</dd>
      
        <hr class="divider" />
        <div class="d-flex justify-content-start align-items-start">
            <a href="/dashboard/report-motor" class="btn btn-danger me-2">
                Kembali
            </a>
            <a class="btn btn-warning me-2">
                Print <i class="fas fa-print"></i>
            </a>
            
        </div>
      </dl>
</div>

@endsection