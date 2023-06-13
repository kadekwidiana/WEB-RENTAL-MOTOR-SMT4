<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan pengeluaran</title>
    <style>
        table {
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
        }
        th {
            background-color: gray;
            color: black;
        }
    </style>
</head>
<body>
    <div>
        <h1>Laporan Pengeluaran</h1>
    </div>
    <table>
        <thead>
            <tr>
                <th>No.</th> 
                <th>Motor</th>
                <th>Pegawai</th>
                <th>Tanggal Pengeluaran</th>
                <th>Jenis Pengeluaran</th>
                <th>Biaya Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengeluarans as $pengeluaran)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pengeluaran->motor->nama_motor }}  {{ $pengeluaran->plat_motor }}</td>
                    <td>{{ $pengeluaran->pegawai->nama_pegawai }}</td>
                    <td>{{ date('d F Y', strtotime($pengeluaran->tgl_pengeluaran)) }}</td>
                    <td>{{ $pengeluaran->jenis_pengeluaran }}</td>
                    <td>{{ number_format($pengeluaran->biaya_pengeluaran, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                    {{-- <th rowspan="2">Nama</th> --}}
                    <th colspan="5">Total</th>
                    <td>Rp. {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                </tr>
        </tbody>
        
    </table>
</body>
</html>