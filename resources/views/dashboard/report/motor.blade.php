@extends('layouts.main')

@section('content')
<div class="container">
    {{-- filter/pencarian --}}
    <div class="row mb-2">
        {{-- Pencarian motor --}}
        <div class="col">
            <form action="{{ route('report.motor') }}" method="GET">
            <div class="input-group mb-3">
              <input name="search" type="text" value="{{ request('search') }}" class="form-control" placeholder="Cari...">
              <button class="btn btn-secondary" type="submit" id="button-addon2">Cari</button>
            </div>
          </form>
          </div>
        </div>
    <table class="table">
        <thead>
            <table class="table table-bordered text-center">
            <tr>
                <th>No.</th>
                <th>Motor</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Total</th>
                <th>Ket / Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($motors as $motor)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $motor->nama_motor }} ({{ $motor->plat_motor }})</td>
                    <td>
                        @php
                            $pemasukan = $motor->transaksi->sum('total');
                            echo number_format($pemasukan, 0, ',', '.')
                        @endphp
                    </td>
                    <td>
                        @php
                            $pengeluaran = $motor->pengeluaran->sum('biaya_pengeluaran');
                            echo number_format($pengeluaran, 0, ',', '.')
                        @endphp
                    </td>
                    <td>{{ number_format($pemasukan - $pengeluaran, 0, ',', '.') }}</td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center">
                            <a href="/dashboard/report-motor/{{ $motor->plat_motor }}/detail" class="btn btn-sm btn-info me-2">
                                Detail
                            </a>
                            <a class="btn btn-sm btn-warning me-2">
                                <i class="fas fa-print"></i>
                            </a>
                            
                        </div>
                    </td>
                </tr>
            @endforeach
            
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-end mt-2">
    {{ $motors->links() }}
</div>
@endsection