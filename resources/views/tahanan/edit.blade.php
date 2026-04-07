@extends('layouts.main')

@section('title', 'Edit Data Tahanan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h4 class="fw-bold mb-0 text-dark">Edit Data Tahanan</h4>
            <p class="text-muted small mb-0">Perbarui informasi identitas warga binaan.</p>
        </div>
        <a href="{{ route('tahanan.index') }}" class="btn btn-secondary shadow-sm px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-5" style="border-radius: 12px;">
        <div class="card-body p-4">
            <form action="{{ route('tahanan.update', $tahanan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nama Tahanan</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                               value="{{ old('nama', $tahanan->nama) }}" placeholder="Nama Lengkap">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Kode NAPI / Tahanan</label>
                        <input type="text" name="code_napi" class="form-control @error('code_napi') is-invalid @enderror" 
                               value="{{ old('code_napi', $tahanan->code_napi) }}" placeholder="Contoh: A.I/24/XXX">
                        @error('code_napi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nama Ayah Kandung</label>
                        <input type="text" name="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror" 
                               value="{{ old('nama_ayah', $tahanan->nama_ayah) }}">
                        @error('nama_ayah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                            <option value="Pria" {{ $tahanan->jenis_kelamin == 'Pria' ? 'selected' : '' }}>Pria</option>
                            <option value="Wanita" {{ $tahanan->jenis_kelamin == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                        </select>
                        @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">Perkara</label>
                        <textarea name="perkara" class="form-control @error('perkara') is-invalid @enderror" rows="3">{{ old('perkara', $tahanan->perkara) }}</textarea>
                        @error('perkara') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                    <button type="submit" class="btn btn-warning text-white px-4 shadow-sm fw-bold">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection