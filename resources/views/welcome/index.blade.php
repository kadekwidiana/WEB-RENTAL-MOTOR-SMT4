@extends('layouts.main')

@section('content')
    <h1>Selamat datang {{ Auth::user()->nama_pegawai }} di halaman admin</h1>
@endsection