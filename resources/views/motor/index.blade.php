@extends('layouts.main')

@section('content')
    <div class="container">
        @can('manajer')
          <a href="{{ route('motor.create') }}" class="btn btn-primary mb-3">Tambah Motor</a>
        @endcan
        @can('owner')
          <a href="{{ route('motor.create') }}" class="btn btn-primary mb-3">Tambah Motor</a>
        @endcan
        {{-- filter/pencarian --}}
        <div class="row mb-2">
            <div class="col">
              <form action="{{ route('motor.index') }}" method="GET">
                <div class="input-group mb-3">
                  <a href="{{ route('motor.index') }}" class="btn btn-secondary"><i class="fas fa-retweet"></i></a>
                  <select name="filter" id="filter" class="form-select">
                    <option value="">--Filter status--</option>
                    <option value="1" {{ request('filter') == '1' ? 'selected' : '' }}>Tersedia</option>
                    <option value="0" {{ request('filter') == '0' ? 'selected' : '' }}>Disewakan</option>
                  </select>
                  <button class="btn btn-secondary" type="submit" id="button-addon2"><i class="fas fa-filter"></i></button>
                </div>
              </form>
            </div>
  
            <div class="col">
              <form action="{{ route('motor.index') }}" method="GET">
                <div class="input-group mb-3">
                  <select name="filter" id="filter" class="form-select">
                    <option value="">--Filter tipe motor--</option>
                    @foreach (['Honda', 'Yamaha', 'Suzuki', 'Ninja', 'Trail',] as $item)
                      <option value="{{ $item }}" {{ request('filter') == $item ? 'selected' : ''  }}>{{ $item }}</option>
                    @endforeach
                    
                  </select>
                  <button class="btn btn-secondary" type="submit" id="button-addon2"><i class="fas fa-filter"></i></button>
                </div>
              </form>
            </div>
            {{-- Pencarian motor --}}
            <div class="col-7">
              <form action="{{ route('motor.index') }}" method="GET">
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
                    <th>Plat Motor</th>
                    <th>Merek Motor</th>
                    <th>Tipe</th>
                    <th>Tahun</th>
                    <th>Harga Sewa</th>
                    <th>Status</th>
                    <th>Gambar Motor</th>
                    <th>Tanggal Catat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
            $no = 1;
          @endphp
                @foreach ($motors as $motor)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $motor->plat_motor }}</td>
                        <td>{{ $motor->nama_motor }} {{ $motor->cc }} cc.</td>
                        <td>{{ $motor->tipe }}</td>
                        <td>{{ $motor->tahun }}</td>
                        <td>{{ number_format($motor->harga_sewa, 0, ',', '.') }}</td>
                        <td>
                            @if ($motor->status == 1)
                                <span class="badge bg-success">Tersedia</span>
                            @else
                                <span class="badge bg-secondary">Disewakan</span>
                            @endif
                        </td>
                        <td><img src="{{ asset('storage/' . $motor->gambar_motor) }}" width="150" alt=""></td>
                        <td>{{ date('d F Y', strtotime($motor->tgl_catat)) }}</td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center">
                                <a class="btn btn-sm btn-info me-2" data-bs-toggle="modal" data-bs-target="#{{ $motor->plat_motor }}">
                                    Detail
                                </a>
                                
                                @can('manajer')
                                <a href="{{ route('motor.edit', $motor->plat_motor) }}" class="btn btn-sm btn-success me-2" title="Edit">
                                  Edit
                              </a>
                              <form action="{{ route('motor.destroy', $motor->plat_motor) }}" method="POST" class="d-inline">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus motor ini?')" title="Hapus">
                                      Hapus
                                  </button>
                              </form>
                                @endcan

                                @can('owner')
                                <a href="{{ route('motor.edit', $motor->plat_motor) }}" class="btn btn-sm btn-success me-2" title="Edit">
                                  Edit
                              </a>
                              <form action="{{ route('motor.destroy', $motor->plat_motor) }}" method="POST" class="d-inline">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus motor ini?')" title="Hapus">
                                      Hapus
                                  </button>
                              </form>
                                @endcan
                                
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="{{ $motor->plat_motor }}" tabindex="-1" aria-labelledby="tesLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-lg">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="tesLabel">Detail Motor</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  <div class="row">
                                      <div class="col-md-6">
                                          <img src="{{ asset('storage/' . $motor->gambar_motor) }}" width="100%" alt="">
                                      </div>
                                      <div class="col-md-6">
                                          <p><strong>Merek Motor: </strong>{{ $motor->nama_motor }}</p>
                                          <p><strong>CC: </strong>{{ $motor->cc }} cc</p>
                                          <p><strong>Warna: </strong>{{ $motor->warna }}</p>
                                          <p><strong>Tipe: </strong>{{ $motor->tipe }}</p>
                                          <p><strong>Tahun: </strong>{{ $motor->tahun }}</p>
                                          <p><strong>Harga Sewa: </strong>Rp. {{ number_format($motor->harga_sewa, 0, ',', '.') }}</p>
                                          <p><strong>Status: </strong>
                                              @if ($motor->status == 1)
                                                  <span class="badge bg-success">Tersedia</span>
                                              @else
                                                  <span class="badge bg-secondary">Disewakan</span>
                                              @endif
                                          </p>
                                      </div>
                                  </div>
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
    </div>

  @empty($motor)
    <div class="text-center" style="font-weight: bold">
      <h5 style="font-weight: bold">Data motor belum ada</h5>
      <a href="{{ route('motor.create') }}" class="">Tambah data motor ?</a>
    </div>
  @endempty

    <div class="d-flex justify-content-end mt-2">
        {{ $motors->links() }}
    </div>
  
@endsection