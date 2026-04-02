@extends('layouts.main')

@section('title', 'Tambah Tahanan')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="fw-bold text-dark">Tambah Tahanan</h4>
        <p class="text-muted">Input data warga binaan baru ke dalam sistem.</p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold text-secondary">Formulir Data Tahanan</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('tahanan.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Code NAPI</label>
                            <input type="text" name="code_napi" class="form-control @error('code_napi') is-invalid @enderror" value="{{ old('code_napi') }}" placeholder="Contoh: 24/A/I/...">
                            @error('code_napi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah') }}" placeholder="Masukkan nama ayah">
                            @error('nama_ayah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Pria" {{ old('jenis_kelamin') == 'Pria' ? 'selected' : '' }}>Pria</option>
                                <option value="Wanita" {{ old('jenis_kelamin') == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                            </select>
                            @error('jenis_kelamin') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <a href="{{ route('tahanan.index') }}" class="btn btn-light px-4 border">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection