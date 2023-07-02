@extends('layouts.main')

@section('content')
  {{-- filter/pencarian --}}
  <div class="row mb-2">
    <div class="col">
      <form action="{{ route('penyewa.index') }}" method="GET">
        <div class="input-group mb-3">
          <a href="{{ route('penyewa.index') }}" class="btn btn-secondary"><i class="fas fa-retweet"></i></a>
          <select name="filter" id="filter" class="form-select">
            <option value="">--Filter jenis kelamin--</option>
            <option value="Laki-laki" {{ request('filter') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ request('filter') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
          </select>
          <button class="btn btn-secondary" type="submit" id="button-addon2"><i class="fas fa-filter"></i></button>
        </div>
      </form>
    </div>
    {{-- Pencarian motor --}}
    <div class="col-8">
      <form action="{{ route('penyewa.index') }}" method="GET">
      <div class="input-group mb-3">
        <input name="search" type="text" value="{{ request('search') }}" class="form-control" placeholder="Cari...">
        <button class="btn btn-secondary" type="submit" id="button-addon2">Cari</button>
      </div>
    </form>
    </div>
  </div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No.</th>
            <th>No Paspor</th>
            <th>Nama Penyewa</th>
            <th>Email</th>
            <th>Jenis Kelamin</th>
            <th>Alamat Domisili</th>
            <th>No Telepon</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($penyewas as $penyewa)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $penyewa->no_paspor }}</td>
            <td>{{ $penyewa->nama_penyewa }}</td>
            <td>{{ $penyewa->email }}</td>
            <td>{{ $penyewa->jenis_kelamin }}</td>
            <td>{{ $penyewa->domisili }}</td>
            <td>{{ $penyewa->no_telepon }}</td>

            <td>
              <a class="btn btn-sm btn-info me-2" data-bs-toggle="modal" data-bs-target="#paspor{{ $penyewa->no_paspor }}">
                Detail
              </a>
                <form class="d-inline" action="{{ route('penyewa.destroy', $penyewa->no_paspor) }}" method="POST">
                  @csrf
                  @method('delete')
                  <button class="btn btn-danger btn-sm mt-1" onclick="return confirm('Hapus data penyewa ini?')">Hapus</button>
                </form>
                
            </form>
          </td>
        </tr>

        <!-- Modal -->
        <div class="modal fade" id="paspor{{ $penyewa->no_paspor }}" tabindex="-1" aria-labelledby="tesLabel" aria-hidden="true">
          <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="tesLabel">Detail Penyewa</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p><strong>No paspor : </strong>{{ $penyewa->no_paspor }}</p>
                <p><strong>Nama penyewa : </strong>{{ $penyewa->nama_penyewa }}</p>
                <p><strong>Email : </strong>{{ $penyewa->email }}</p>
                <p><strong>Asal Negara : </strong>{{ $penyewa->asal_negara }}</p>
                <p><strong>Jenis Kelamin : </strong>{{ $penyewa->jenis_kelamin }}</p>
                <p><strong>Alamat Domisili : </strong>{{ $penyewa->domisili }}</p>
                <p><strong>No Telepon : </strong>{{ $penyewa->no_telepon }}</p>
                <p><strong>No Sim : </strong>{{ $penyewa->no_sim }}</p>
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

  @empty($penyewa)
    <div class="text-center" style="font-weight: bold">
      <h5 style="font-weight: bold">Data penyewa belum ada</h5>
      <a href="{{ route('transaksi.create') }}" class="">Tambah data penyewa ?</a>
    </div>
  @endempty

  <div class="d-flex justify-content-end mt-2">
    {{ $penyewas->links() }}
</div>
@endsection
