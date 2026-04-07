@extends('layouts.main')

@section('title', 'Edit Data Keluarga')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h4 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Data Keluarga</h4>
            <p class="text-muted small mb-0">Perbarui Data Keluarga: <strong>{{ $penitip->nama }}</strong></p>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-10 col-lg-12">
            <div class="card shadow-sm border-0 mb-5" style="border-radius: 15px;">
                <div class="card-header bg-warning py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-person-lines-fill me-2"></i>Formulir Pembaruan Data</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('penitip.update', $penitip->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nama" class="form-control border-start-0 @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $penitip->nama) }}" placeholder="Nama Lengkap">
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">NIK</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-badge"></i></span>
                                    <input type="number" name="nik" class="form-control border-start-0 @error('nik') is-invalid @enderror"
                                        value="{{ old('nik', $penitip->nik) }}" placeholder="NIK 16 Digit"
                                        oninput="if (this.value.length > 16) this.value = this.value.slice(0, 16);">
                                    @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">No. Handphone (WA)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-whatsapp"></i></span>
                                    <input type="number" name="hp" class="form-control border-start-0 @error('hp') is-invalid @enderror"
                                        value="{{ old('hp', $penitip->hp) }}" placeholder="0812xxxxxxxx"
                                        oninput="if (this.value.length > 13) this.value = this.value.slice(0, 13);">
                                    @error('hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Foto Diri (Saat Ini)</label>
                                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded border shadow-sm">
                                    @php $pathF = str_contains($penitip->foto, 'foto_diri/') ? $penitip->foto : 'foto_diri/' . $penitip->foto; @endphp
                                    <div class="text-center p-1 bg-white rounded border">
                                        <img src="{{ asset('storage/' . $pathF) }}" class="rounded shadow-sm" 
                                             style="height: 120px; width: 120px; object-fit: contain; background-color: #f8f9fa;">
                                        <small class="d-block text-muted mt-1 small">Foto Lama</small>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-label small fw-bold text-dark">Ganti Foto Diri</label>
                                        <input type="file" name="foto" class="form-control mb-1" accept="image/*">
                                        <small class="text-muted" style="font-size: 11px;">* Kosongkan jika tidak ingin ganti foto.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Foto KTP (Saat Ini)</label>
                                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded border shadow-sm">
                                    @php $pathK = str_contains($penitip->foto_ktp, 'foto_ktp/') ? $penitip->foto_ktp : 'foto_ktp/' . $penitip->foto_ktp; @endphp
                                    <div class="text-center p-1 bg-white rounded border">
                                        <img src="{{ asset('storage/' . $pathK) }}" class="rounded shadow-sm" 
                                             style="height: 120px; width: 120px; object-fit: contain; background-color: #f8f9fa;">
                                        <small class="d-block text-muted mt-1 small">KTP Lama</small>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-label small fw-bold text-dark">Ganti Foto KTP</label>
                                        <input type="file" name="foto_ktp" class="form-control mb-1" accept="image/*">
                                        <small class="text-muted" style="font-size: 11px;">* Kosongkan jika tidak ingin ganti KTP.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2 pt-4 border-top d-flex justify-content-between align-items-center">
                            <a href="{{ route('penitip.index') }}" class="btn btn-outline-secondary px-4 shadow-sm">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning text-dark px-5 shadow-sm fw-bold">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Fokus efek Kuning (#ffc107) agar konsisten dengan tema EDIT */
    .form-control:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.1);
    }
    .input-group-text {
        color: #6c757d;
        background-color: #f8f9fa;
    }
    /* Menghilangkan spin button pada input number */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endsection