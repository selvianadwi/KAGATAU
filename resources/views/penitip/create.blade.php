@extends('layouts.main')

@section('title', 'Tambah Data Keluarga')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-4 mt-4">
        {{-- Icon diubah jadi biru --}}
        <h4 class="fw-bold text-dark"><i class="bi bi-person-vcard-fill me-2 text-primary"></i>Registrasi Data Keluarga Baru</h4>
        <p class="text-muted small">Lengkapi formulir identitas Keluarga Tahanan Baru.</p>
    </div>

    <div class="row">
        <div class="col-xl-9 col-lg-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                {{-- Header Card diubah jadi bg-primary (Biru) --}}
                <div class="card-header bg-primary py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0 fw-bold text-white"><i class="bi bi-card-checklist me-2"></i>Formulir Identitas Keluarga</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('penitip.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nama" class="form-control border-start-0 @error('nama') is-invalid @enderror"
                                        value="{{ old('nama') }}" placeholder="Masukkan nama lengkap">
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">NIK (16 Digit)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-badge"></i></span>
                                    <input type="number" name="nik" class="form-control border-start-0 @error('nik') is-invalid @enderror"
                                        value="{{ old('nik') }}" placeholder="3317xxxxxxxxxxxx"
                                        oninput="if (this.value.length > 16) this.value = this.value.slice(0, 16);">
                                    @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">No. Handphone (WhatsApp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-whatsapp"></i></span>
                                    <input type="number" name="hp" class="form-control border-start-0 @error('hp') is-invalid @enderror"
                                        value="{{ old('hp') }}" placeholder="0812xxxxxxxx"
                                        oninput="if (this.value.length > 13) this.value = this.value.slice(0, 13);">
                                    @error('hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-text small text-info"><i class="bi bi-info-circle me-1"></i>Gunakan nomor aktif WhatsApp.</div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Foto Diri (Verifikasi)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-camera"></i></span>
                                    <input type="file" name="foto" class="form-control border-start-0 @error('foto') is-invalid @enderror" accept="image/*">
                                    @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Foto KTP / Identitas</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-image"></i></span>
                                    <input type="file" name="foto_ktp" class="form-control border-start-0 @error('foto_ktp') is-invalid @enderror" accept="image/*">
                                    @error('foto_ktp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-2 pt-4 border-top d-flex justify-content-between align-items-center">
                            <a href="{{ route('penitip.index') }}" class="btn btn-outline-secondary px-4 shadow-sm">
                                <i class="bi bi-arrow-left-circle me-1"></i> Batal
                            </a>
                            {{-- Tombol simpan diubah jadi btn-primary (Biru) --}}
                            <button type="submit" class="btn btn-primary px-5 shadow-sm fw-bold">
                                <i class="bi bi-cloud-check me-1"></i> Daftarkan Data Keluarga
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Fokus efek pada input diubah jadi biru (#0d6efd) */
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    .input-group-text {
        color: #6c757d;
        background-color: #f8f9fa;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endsection