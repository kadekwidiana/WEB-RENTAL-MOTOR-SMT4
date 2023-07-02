@extends('layouts.main')

@section('content')
{{-- <div class="d-flex">
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Tambah Transaksi</a>
</div>

<div class="mt-3 justify-content-center">
    <form action="{{ route('transaksi.index') }}" method="GET">
      <div class="row">
        <div class="col">
          <div class="input-group mb-2">
            <input type="text" value="{{ request('search') }}" class="form-control" placeholder="Cari data transaksi...." name="search">
          </div>
        </div>
        <div class="col-1">
        <button class="btn btn-secondary" type="submit">Cari</button>
        </div>
      </div>
    </form>
  </div> --}}
  {{-- Menampilkan pengembalian --}}
  
    {{-- <button type="button" class="btn btn-outline-warning mb-2 fw-bold text-dark" id="toggleButton">Tampilkan Pengembalian</button> --}}
    {{-- <button type="button" class="btn btn-outline-secondary mb-2 fw-bold text-dark" id="hideButton">Tampilkan sudah di kembalikan</button>

    <div class="div3">
      div 3
    </div> --}}
    {{-- <button type="button" class="btn btn-outline-secondary mb-2 fw-bold text-dark" id="hideButton">Tampilkan yang sudah di kembalikan</button> --}}

{{-- <div id="div3" style="display: none;">
  <table  class="table table-bordered">
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
          <th>Ket</th>
      </tr>
  </thead>
  <tbody>
    @php
        $no = 1;
    @endphp
    @foreach ($transaksis as $transaksi)
    <tr>
      @if ($transaksi->status_transaksi == 1)
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
            <button href="" class="btn btn-outline-success btn-sm mt-1" >Pengembalian success</button>
            
          </td>
      @endif
        
    </tr>
    @endforeach
</tbody>
  </table>

</div> --}}

  {{-- PENYEWAAN --}}
  {{-- <table id="div1" class="table table-bordered">
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
                <a href="{{ route('transaksi.edit', $transaksi->kode_transaksi) }}" class="btn btn-success btn-sm mt-1">Edit</a>
                <button type="button" class="btn btn-info btn-sm mt-1" data-bs-toggle="modal" data-bs-target="#{{ $transaksi->kode_transaksi }}">
                  Detail
                </button>
                <form class="d-inline" action="{{ route('transaksi.destroy', $transaksi->kode_transaksi) }}" method="POST">
                  @csrf
                  @method('delete')
                  <button class="btn btn-danger btn-sm mt-1" onclick="return confirm('Hapus data transaksi ini?')">Hapus</button>
                </form>
              </td>
        </tr> --}}
          <!-- Modal Detail Transaksi -->
        {{-- <div class="modal fade" id="{{ $transaksi->kode_transaksi }}" tabindex="-1" aria-labelledby="{{ $transaksi->kode_transaksi }}Label" aria-hidden="true">
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
  </table> --}}

  {{-- PENGEMBALIAN --}}
  {{-- <table id="div2" style="display: none;" class="table table-bordered">
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
            <th>Ket/Aksi</th>
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
                
              </td>
          @endif
            
        </tr>
        @endforeach
    </tbody>
  </table>

  <div class="d-flex justify-content-end mt-2">
    {{ $transaksis->links() }}
  </div>

  <p><strong>Total Transaksi : </strong>Rp. {{ number_format($totalTransaksi, 0, ',', '.') }}</p>
  @empty($transaksi)
    <div class="text-center" style="font-weight: bold">
      <h5 style="font-weight: bold">Data Transaksi belum ada</h5>
      <a href="{{ route('transaksi.create') }}" class="">Buat Transaksi ?</a>
    </div>
  @endempty --}}

  {{-- <script>
    // Mengambil referensi elemen tombol dan div
    var toggleButton = document.getElementById("toggleButton");
    var div1 = document.getElementById("div1");
    var div2 = document.getElementById("div2");
    var div3 = document.getElementById("div3");

   // Fungsi untuk menampilkan div3 dan menghilangkan div1 dan div2
    function showDiv3() {
      div1.style.display = "none";
      div2.style.display = "none";
      div3.style.display = "block";
    }

    // Event listener untuk tombol "Tampilkan sudah di kembalikan"
    document.getElementById("hideButton").addEventListener("click", function () {
      showDiv3();
    });
  
    // Mendefinisikan status tampilan awal
    var isDiv1Visible = true;
  
    // Mendapatkan status tampilan dari local storage saat halaman dimuat
    window.addEventListener("load", function() {
      var storedStatus = localStorage.getItem("divStatus");
      if (storedStatus !== null) {
        isDiv1Visible = JSON.parse(storedStatus);
      }
      updateDiv();
    });
  
    // Fungsi untuk memperbarui tampilan div dan menyimpan status di local storage
    function updateDiv() {
      if (isDiv1Visible) {
        div1.style.display = "block"; // Tampilkan div1
        div2.style.display = "none"; // Sembunyikan div2
        div3.style.display = "none"; // Sembunyikan div2
        toggleButton.innerText = "Tampilkan Pengembalian"; // Ubah teks tombol
      } else {
        div1.style.display = "none"; // Sembunyikan div1
        div2.style.display = "block"; // Tampilkan div2
        div3.style.display = "none"; // Tampilkan div2
        toggleButton.innerText = "Tampilkan Penyewaan"; // Ubah teks tombol
      }
  
      // Simpan status tampilan ke local storage
      localStorage.setItem("divStatus", JSON.stringify(isDiv1Visible));
    }
  
    // Fungsi untuk membalik nilai status tampilan dan memperbarui div
    function toggleDiv() {
      isDiv1Visible = !isDiv1Visible; // Membalik nilai status
      updateDiv(); // Memperbarui tampilan div
    }
  
    // Menambahkan event listener untuk tombol
    toggleButton.addEventListener("click", toggleDiv);
  </script> --}}
@endsection
