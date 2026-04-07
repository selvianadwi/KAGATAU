@extends('layouts.main')

@section('title', 'Edit Data Tahanan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h4 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Data Tahanan</h4>
            <p class="text-muted small mb-0">Perbarui informasi identitas warga binaan: <strong>{{ $tahanan->nama }}</strong></p>
        </div>
        <a href="{{ route('tahanan.index') }}" class="btn btn-outline-secondary shadow-sm px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-10">
            <div class="card shadow-sm border-0 mb-5" style="border-radius: 15px;">
                <div class="card-header bg-warning py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-person-lines-fill me-2"></i>Perubahan Identitas</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('tahanan.update', $tahanan->id) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Nama Lengkap Tahanan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" name="nama" class="form-control border-start-0 @error('nama') is-invalid @enderror" 
                                           value="{{ old('nama', $tahanan->nama) }}" placeholder="Nama Lengkap">
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Kode NAPI / Tahanan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-hash"></i></span>
                                    <input type="text" name="code_napi" class="form-control border-start-0 @error('code_napi') is-invalid @enderror" 
                                           value="{{ old('code_napi', $tahanan->code_napi) }}" placeholder="Contoh: A.I/24/XXX">
                                    @error('code_napi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Jenis Kelamin</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-gender-ambiguous"></i></span>
                                    <select name="jenis_kelamin" class="form-select border-start-0 @error('jenis_kelamin') is-invalid @enderror">
                                        <option value="Pria" {{ old('jenis_kelamin', $tahanan->jenis_kelamin) == 'Pria' ? 'selected' : '' }}>Pria</option>
                                        <option value="Wanita" {{ old('jenis_kelamin', $tahanan->jenis_kelamin) == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                                    </select>
                                    @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Nama Ayah</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-people"></i></span>
                                    <input type="text" name="nama_ayah" class="form-control border-start-0 @error('nama_ayah') is-invalid @enderror" 
                                           value="{{ old('nama_ayah', $tahanan->nama_ayah) }}" placeholder="Nama Ayah">
                                    @error('nama_ayah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-2 pt-4 border-top d-flex justify-content-between align-items-center">
                            <small class="text-muted italic">* Pastikan data sudah sesuai dengan dokumen fisik.</small>
                            <button type="submit" class="btn btn-warning text-dark px-5 shadow-sm fw-bold">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-4 d-none d-xl-block">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background-color: #fff9eb;">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-warning-emphasis"><i class="bi bi-exclamation-triangle-fill me-2"></i>Catatan Edit</h6>
                    <hr>
                    <p class="small text-dark mb-2">Mengubah data identitas akan berdampak pada:</p>
                    <ul class="small text-muted ps-3">
                        <li class="mb-2">Riwayat pencarian di menu <strong>Layanan Kagatau</strong>.</li>
                        <li class="mb-2">Sinkronisasi data pada daftar keluarga/penitip yang terhubung.</li>
                        <li class="mb-2">Pastikan <strong>Code NAPI</strong> tidak tertukar dengan tahanan lain.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.1);
    }
    .input-group-text {
        color: #6c757d;
    }
</style>
@endsection