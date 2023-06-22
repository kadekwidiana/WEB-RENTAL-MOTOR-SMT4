@extends('layouts.main')

@section('content')
  <h1>Detail Pesan</h1>

  <p><strong>Nama:</strong> {{ $contact->nama }}</p>
  <p><strong>Email:</strong> {{ $contact->email }}</p>
  <p><strong>Subjek:</strong> {{ $contact->subjek }}</p>
  <p><strong>Pesan:</strong> {{ $contact->pesan }}</p>

  <a href="{{ route('contact-admin.index') }}">Kembali</a>
@endsection
