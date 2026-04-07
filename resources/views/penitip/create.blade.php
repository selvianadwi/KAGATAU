@extends('layouts.main')

@section('title', 'Tambah Penitip')

@section('content')
    <div class="container-fluid px-4">
        <div class="mt-4 mb-4">
            <h4 class="fw-bold text-dark">Registrasi Penitip Baru</h4>
            <p class="text-muted small">Lengkapi formulir identitas pengunjung di bawah ini.</p>
        </div>

        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body p-4">
                <form action="{{ route('penitip.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}" placeholder="Masukkan nama">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">NIK (16 Digit)</label>
                            <input type="number" name="nik" class="form-control @error('nik') is-invalid @enderror"
                                value="{{ old('nik') }}"
                                oninput="if (this.value.length > 16) this.value = this.value.slice(0, 16);">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">No. Handphone</label>
                            <input type="number" name="hp" class="form-control @error('hp') is-invalid @enderror"
                                value="{{ old('hp') }}" placeholder="0812xxxxxxxx"
                                oninput="if (this.value.length > 13) this.value = this.value.slice(0, 13);">
                            <div class="form-text">Maksimal 15 digit.</div>
                            @error('hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Foto Diri</label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"
                                accept="image/*">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Foto KTP</label>
                            <input type="file" name="foto_ktp"
                                class="form-control @error('foto_ktp') is-invalid @enderror" accept="image/*">
                            @error('foto_ktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('penitip.index') }}" class="btn btn-light px-4 border">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
