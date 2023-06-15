@extends('layouts.main')

@section('content')
<div class="container">
    {{-- filter/pencarian --}}
    <div class="row mb-2">
        {{-- filter/pencarian --}}
        <div class="row mb-2">
            <div class="col">
              <form action="{{ route('report.motor') }}" method="GET">
                <div class="input-group mb-3">
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
  
            {{-- <div class="col">
              <form action="{{ route('report.motor') }}" method="GET">
                <div class="input-group mb-3">
                  <select name="filter" id="filter" class="form-select">
                    <option value="">--Filter motor--</option>
                    @foreach (['Beat', 'Vario', 'Nmax', 'PCX', 'Scoopy', 'Fazzio', 'ADV'] as $item)
                      <option value="{{ $item }}" {{ request('filter') == $item ? 'selected' : ''  }}>{{ $item }}</option>
                    @endforeach
                    
                  </select>
                  <button class="btn btn-secondary" type="submit" id="button-addon2"><i class="fas fa-filter"></i></button>
                </div>
              </form>
            </div> --}}
            {{-- Pencarian pengeluaran --}}
            <div class="col-8">
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