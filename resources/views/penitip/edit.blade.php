@extends('layouts.main')

@section('title', 'Edit Penitip')

@section('content')
    <div class="container-fluid px-4">
        <div class="mt-4 mb-4">
            <h4 class="fw-bold text-dark">Edit Data Penitip</h4>
        </div>

        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body p-4">
                <form action="{{ route('penitip.update', $penitip->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $penitip->nama) }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">NIK</label>
                            <input type="number" name="nik" class="form-control @error('nik') is-invalid @enderror"
                                value="{{ old('nik', $penitip->nik) }}">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">No. Handphone</label>
                            <input type="number" name="hp" class="form-control @error('hp') is-invalid @enderror"
                                value="{{ old('hp', $penitip->hp) }}"
                                oninput="if (this.value.length > 13) this.value = this.value.slice(0, 13);">
                            @error('hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-3 text-center">
                            <label class="form-label fw-semibold d-block text-start">Foto Diri Baru (Opsional)</label>
                            @php $pathF = str_contains($penitip->foto, 'foto_diri/') ? $penitip->foto : 'foto_diri/' . $penitip->foto; @endphp
                            <img src="{{ asset('storage/' . $pathF) }}" class="img-thumbnail mb-2" style="height: 120px;">
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6 mb-3 text-center">
                            <label class="form-label fw-semibold d-block text-start">Foto KTP Baru (Opsional)</label>
                            @php $pathK = str_contains($penitip->foto_ktp, 'foto_ktp/') ? $penitip->foto_ktp : 'foto_ktp/' . $penitip->foto_ktp; @endphp
                            <img src="{{ asset('storage/' . $pathK) }}" class="img-thumbnail mb-2" style="height: 120px;">
                            <input type="file" name="foto_ktp" class="form-control" accept="image/*">
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('penitip.index') }}" class="btn btn-light px-4 border">Batal</a>
                        <button type="submit" class="btn btn-warning text-white px-4 shadow-sm">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
