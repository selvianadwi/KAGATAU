@extends('layouts.main')
@section('title', 'Upload Dokumentasi Layanan')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
            <h4 class="fw-bold mb-0 text-dark">Upload Dokumentasi Layanan KAGATAU</h4>
            <p class="text-muted small mb-0">Lengkapi bukti screenshot dan foto layanan.</p>
        </div>
        <a href="{{ route('layanan.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-5 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 12px; background-color: #f8f9fa;">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3">Detail Data Layanan</h6>
                    
                    @php
                        // Bersihkan nama agar tidak muncul [""]
                        $namaK = str_replace(['[', ']', '"'], '', (string)($layanan->keluarga->nama ?? 'N/A'));
                        $namaT = str_replace(['[', ']', '"'], '', (string)($layanan->keluarga->nama_wbp ?? 'N/A'));
                    @endphp

                    <div class="mb-2">
                        <small class="text-muted d-block">Tanggal Masuk (Auto)</small>
                        <span class="fw-semibold">{{ $layanan->tanggal_masuk }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block">Tanggal Layanan</small>
                        <span class="fw-semibold text-primary">
                            {{ \Carbon\Carbon::parse($layanan->tanggal_layanan)->format('d/m/Y') }}
                        </span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block">Nama Tahanan</small>
                        <span class="fw-bold text-dark">{{ strtoupper($namaT) }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block">Nama Keluarga (Penitip)</small>
                        <span class="fw-semibold text-dark">{{ strtoupper($namaK) }}</span>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted d-block">No. HP Target</small>
                        <span class="fw-semibold">{{ $layanan->hp_manual ?? ($layanan->keluarga->hp ?? '-') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-7">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <form action="{{ route('layanan.update', $layanan->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-upload me-2"></i>Unggah File Foto</h6>
                        
                        <div class="row">
                            <div class="col-md-12 col-lg-6 mb-4">
                                <label class="form-label fw-semibold text-success">
                                    <i class="bi bi-whatsapp me-1"></i> Screenshot Bukti
                                </label>
                                <input type="file"  name="screenshot" class="form-control border-success-subtle shadow-sm">
                                <div class="form-text small">Format: JPG, PNG (Maks. 2MB).</div>
                                
                                @if($layanan->screenshot)
                                    <div class="mt-3 p-2 bg-light rounded border border-success">
                                        <small class="text-muted d-block mb-1 text-center">Bukti Saat Ini:</small>
                                        <div class="text-center">
                                            <img src="{{ asset('storage/' . $layanan->screenshot) }}" alt="Screenshot WA" class="img-thumbnail rounded shadow-sm" style="max-height: 150px;">
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12 col-lg-6 mb-4">
                                <label class="form-label fw-semibold text-primary">
                                    <i class="bi bi-camera me-1"></i> Foto Dokumentasi Layanan
                                </label>
                                <input type="file" name="dokumentasi" class="form-control border-primary-subtle shadow-sm">
                                <div class="form-text small">Format: JPG, PNG (Maks. 2MB).</div>

                                @if($layanan->dokumentasi)
                                    <div class="mt-3 p-2 bg-light rounded border border-primary">
                                        <small class="text-muted d-block mb-1 text-center">Dokumentasi Saat Ini:</small>
                                        <div class="text-center">
                                            <img src="{{ asset('storage/' . $layanan->dokumentasi) }}" alt="Dokumentasi" class="img-thumbnail rounded shadow-sm" style="max-height: 150px;">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-5 shadow-sm py-2">
                                <i class="bi bi-cloud-upload me-1"></i> Simpan Dokumentasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection