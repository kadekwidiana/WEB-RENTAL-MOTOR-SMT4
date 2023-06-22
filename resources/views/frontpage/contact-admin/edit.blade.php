@extends('frontpage.layouts.main')

@section('content')
  <h1>Edit Pesan</h1>

  <form action="{{ route('contacts.update', $contact->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
      <input type="text" name="nama" class="form-control" placeholder="Nama" value="{{ $contact->nama }}" required>
    </div>
    <div class="form-group">
      <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $contact->email }}" required>
    </div>
    <div class="form-group">
      <input type="text" name="subjek" class="form-control" placeholder="Subjek" value="{{ $contact->subjek }}" required>
    </div>
    <div class="form-group">
      <textarea name="pesan" class="form-control" placeholder="Pesan" required>{{ $contact->pesan }}</textarea>
    </div>
    <div class="form-group">
      <input type="submit" value="Simpan Perubahan" class="btn btn-primary py-3 px-5">
    </div>
  </form>
@endsection
