@extends('layouts.main')

@section('content')
<table>
    <thead>
        <tr>
            <th>Bulan</th>
            <th>Total Transaksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($laporanPerBulan as $laporan)
            <tr>
                <td>{{ $laporan['bulan'] }}</td>
                <td>{{ $laporan['totalTransaksi'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection