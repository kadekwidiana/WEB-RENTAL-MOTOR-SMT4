@extends('layouts.main')

@section('content')
<div class="container">
    <dl class="row">
        <dt class="col-sm-3">Nama Motor</dt>
        <dd class="col-sm-9">: {{ $motor->nama_motor }} {{ $motor->plat_motor }}</dd>
      
        <dt class="col-sm-3">Pemasukan</dt>
        <dd class="col-sm-9">: Rp. 
            @php
                $pemasukan = $motor->transaksi->sum('total');
                echo number_format($pemasukan, 0, ',', '.')
            @endphp
        </dd>

        <dt class="col-sm-3">Pengeluaran</dt>
        <dd class="col-sm-9">: Rp. 
            @php
                $pengeluaran = $motor->pengeluaran->sum('biaya_pengeluaran');
                echo number_format($pengeluaran, 0, ',', '.')
            @endphp
        </dd>

        <dt class="col-sm-3">Total</dt>
        <dd class="col-sm-9">: Rp. {{ number_format($pemasukan - $pengeluaran, 0, ',', '.') }}</dd>
      
        <div class="d-flex justify-content-start align-items-start">
            <a class="btn btn-warning me-2">
                <i class="fas fa-print"></i>
            </a>
            
        </div>
      </dl>
</div>

@endsection