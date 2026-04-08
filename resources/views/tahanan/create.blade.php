@extends('layouts.main')

@section('title', 'Tambah Tahanan')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-4 mt-4">
        <h4 class="fw-bold text-dark"><i class="bi bi-person-plus-fill me-2"></i>Tambah Tahanan</h4>
        <p class="text-muted">Input data warga binaan baru ke dalam sistem database <strong>Sipirman</strong>.</p>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-10">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-primary py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0 fw-bold text-white"><i class="bi bi-file-earmark-text me-2"></i>Formulir Identitas Tahanan</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('tahanan.store') }}" method="POST" autocomplete="off">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Code NAPI / Tahanan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-hash"></i></span>
                                    {{-- Tambahkan maxlength="10" di sini --}}
                                    <input type="text" name="code_napi" id="code_napi" 
                                           class="form-control border-start-0 @error('code_napi') is-invalid @enderror" 
                                           value="{{ old('code_napi') }}" 
                                           placeholder="Masukan code sesuai berkas" 
                                           maxlength="10"
                                           oninput="if (this.value.length > 10) this.value = this.value.slice(0, 10);">
                                    @error('code_napi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Jenis Kelamin</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-gender-ambiguous"></i></span>
                                    <select name="jenis_kelamin" class="form-select border-start-0 @error('jenis_kelamin') is-invalid @enderror">
                                        <option value="">-- Pilih --</option>
                                        <option value="Pria" {{ old('jenis_kelamin') == 'Pria' ? 'selected' : '' }}>Pria</option>
                                        <option value="Wanita" {{ old('jenis_kelamin') == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                                    </select>
                                    @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Nama Lengkap Tahanan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" name="nama" class="form-control border-start-0 @error('nama') is-invalid @enderror" 
                                           value="{{ old('nama') }}" placeholder="Masukkan nama sesuai berkas">
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Nama Ayah </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-people"></i></span>
                                    <input type="text" name="nama_ayah" class="form-control border-start-0 @error('nama_ayah') is-invalid @enderror" 
                                           value="{{ old('nama_ayah') }}" placeholder="Nama ayah">
                                    @error('nama_ayah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-2 pt-4 border-top d-flex justify-content-between align-items-center">
                            <a href="{{ route('tahanan.index') }}" class="btn btn-outline-secondary px-4 shadow-sm">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm fw-bold">
                                <i class="bi bi-check2-circle me-1"></i> Simpan Data Tahanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        

    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    .input-group-text {
        color: #6c757d;
    }
</style>
@endsection