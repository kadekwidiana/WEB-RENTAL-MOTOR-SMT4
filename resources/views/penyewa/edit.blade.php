@extends('layouts.main')

@section('content')
<div class="align-content-end mb-4">
    <div class="card-body">
        <form action="{{ route('penyewa.update', $penyewa->no_paspor) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="border p-3 rounded">
                <div class="form-group mt-2">
                    <label for="nama_penyewa">Nama Penyewa</label>
                    <input type="text" class="form-control @error('nama_penyewa') is-invalid @enderror" id="nama_penyewa" name="nama_penyewa" value="{{ old('nama_penyewa', $penyewa->nama_penyewa) }}" required autocomplete="nama_penyewa">
                    @error('nama_penyewa')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mt-2">
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $penyewa->email) }}" required autocomplete="email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mt-2">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="Laki-laki" {{ $penyewa->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $penyewa->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mt-2">
                    <label for="domisili">Alamat Domisili</label>
                    <textarea class="form-control @error('domisili') is-invalid @enderror" id="domisili" name="domisili" rows="3" required>{{ old('domisili', $penyewa->domisili) }}</textarea>
                    @error('domisili')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mt-2">
                    <label for="no_telepon">No Telepon</label>
                    <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $penyewa->no_telepon) }}" required autocomplete="no_telepon">
                    @error('no_telepon')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mt-2">
                    <label for="no_sim">No SIM</label>
                    <input type="text" class="form-control @error('no_sim') is-invalid @enderror" id="no_sim" name="no_sim" value="{{ old('no_sim', $penyewa->no_sim) }}" autocomplete="no_sim">
                    @error('no_sim')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
