@extends('layouts.main')

@section('content')
  <h1>send message</h1>

  <form action="{{ route('contact.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <input type="text" name="nama" class="form-control" placeholder="Nama" required>
    </div>
    <div class="form-group">
      <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>
    <div class="form-group">
      <input type="text" name="subjek" class="form-control" placeholder="Subjek" required>
    </div>
    <div class="form-group">
      <textarea name="pesan" class="form-control" placeholder="Pesan" required></textarea>
    </div>
    <div class="form-group">
      <input type="submit" value="Kirim Pesan" class="btn btn-primary py-3 px-5">
    </div>
  </form>
@endsection
