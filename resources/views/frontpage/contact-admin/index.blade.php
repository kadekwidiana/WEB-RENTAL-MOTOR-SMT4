@extends('layouts.main')

@section('content')

  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Subjek</th>
          <th>Pesan</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($contacts as $contact)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $contact->nama }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->subjek }}</td>
            <td>{{ $contact->pesan }}</td>
            <td class="border text-center">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{ $contact->id }}">Lihat</button>
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $contact->id }}">Hapus</button>
            </td>
          </tr>
          <!-- Modal Lihat -->
          <div class="modal fade" id="viewModal{{ $contact->id }}" tabindex="-1" aria-labelledby="viewModal{{ $contact->id }}Label" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="viewModal{{ $contact->id }}Label">Detail Pesan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p><strong>Nama:</strong> {{ $contact->nama }}</p>
                  <p><strong>Email:</strong> {{ $contact->email }}</p>
                  <p><strong>Subjek:</strong> {{ $contact->subjek }}</p>
                  <p><strong>Pesan:</strong> {{ $contact->pesan }}</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal Konfirmasi Hapus -->
          <div class="modal fade" id="deleteModal{{ $contact->id }}" tabindex="-1" aria-labelledby="deleteModal{{ $contact->id }}Label" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteModal{{ $contact->id }}Label">Konfirmasi Hapus</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Apakah Anda yakin ingin menghapus pesan ini?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <form action="{{ route('contact-admin.destroy', $contact->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="pagination justify-content-end">
    {{ $contacts->links('pagination::bootstrap-4') }}
  </div>
@endsection