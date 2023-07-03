 @extends('layouts.main')

@section('content')
<div class="container">
    <dl class="row">
        <div class="row mb-2">
            <div class="col-4">
              <form action="/dashboard/report-motor/{{ $motor->plat_motor }}/detail" method="GET">
                <div class="input-group mb-3">
                  <a href="/dashboard/report-motor/{{ $motor->plat_motor }}/detail" class="btn btn-secondary"><i class="fas fa-retweet"></i></a>
                  <select name="bulan" id="bulan" class="form-select" required>
                    <option value="">--Bulan--</option>
                    <option value="01" {{ request('bulan') == '01' ? 'selected' : '' }}>Januari</option>
                    <option value="02" {{ request('bulan') == '02' ? 'selected' : '' }}>Februari</option>
                    <option value="03" {{ request('bulan') == '03' ? 'selected' : '' }}>Maret</option>
                    <option value="04" {{ request('bulan') == '04' ? 'selected' : '' }}>April</option>
                    <option value="05" {{ request('bulan') == '05' ? 'selected' : '' }}>Mei</option>
                    <option value="06" {{ request('bulan') == '06' ? 'selected' : '' }}>Juni</option>
                    <option value="07" {{ request('bulan') == '07' ? 'selected' : '' }}>Juli</option>
                    <option value="08" {{ request('bulan') == '08' ? 'selected' : '' }}>Agustus</option>
                    <option value="09" {{ request('bulan') == '09' ? 'selected' : '' }}>September</option>
                    <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>Oktober</option>
                    <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November</option>
                    <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>Desember</option>
                  </select>
                  <select name="tahun" id="tahun" class="form-select" required>
                    <option value="">--Tahun--</option>
                    <option value="2022" {{ request('tahun') == '2022' ? 'selected' : '' }}>2022</option>
                    <option value="2023" {{ request('tahun') == '2023' ? 'selected' : '' }}>2023</option>
                    <option value="2024" {{ request('tahun') == '2024' ? 'selected' : '' }}>2024</option>
                    <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>2025</option>
                  </select>
                  <button class="btn btn-secondary" type="submit" id="button-addon2"><i class="fas fa-filter"></i></button>
                </div>
              </form>
            </div>
          </div>
          @php
              $dateMonth = $bulan;
              $dateYear = $tahun;
              $dateTimeMonth = DateTime::createFromFormat('m', $dateMonth);
              $dateTimeYear = DateTime::createFromFormat('Y', $dateYear);
              $month = $dateTimeMonth->format('F');
              $year = $dateTimeYear->format('Y');
              
            @endphp
              <h4>{{$month}} {{ $year }}</h4>
        <dt class="col-sm-1"></dt>
        <dd class="col-sm-9"> 
            <img src="{{ asset('storage/' . $motor->gambar_motor) }}" width="200" alt="">
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