@extends('layouts.main')
@section('title', 'Tambah Layanan')

@section('content')
<div class="container-fluid px-4">
    <div class="mt-4 mb-3">
        <h4 class="fw-bold text-dark"><i class="bi bi-plus-circle-fill me-2 text-primary"></i>Input Data Layanan Baru</h4>
        <p class="text-muted small">Hubungkan data Tahanan dan data Keluarga untuk mendaftarkan antrean.</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <form action="{{ route('layanan.store') }}" method="POST" autocomplete="off">
                        @csrf
                        
                        <div class="row">
                            {{-- Dropdown Pilih Tahanan (Database Sipirman) --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">1. Pilih Tahanan (WBP)</label>
                                <select name="tahanan_id" id="tahanan_select" class="form-select select2" required>
                                    <option value="">-- Cari Nama Tahanan --</option>
                                    @foreach($tahanans as $t)
                                        <option value="{{ $t->id }}">
                                            {{ strtoupper($t->nama) }} — [{{ $t->code_napi }}]
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text small">Sistem mengambil <strong>Tanggal Masuk</strong> dari data tahanan ini.</div>
                            </div>

                            {{-- Dropdown Pilih Keluarga (Database Kagatau) --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">2. Pilih Keluarga (Pengunjung)</label>
                                <select name="penitip_id" id="penitip_select" class="form-select select2" required>
                                    <option value="">-- Cari Nama Keluarga --</option>
                                    @foreach($keluargas as $k)
                                        <option value="{{ $k->id }}">
                                            {{ strtoupper($k->nama) }} — [NIK: {{ $k->nik }}]
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- No. HP Baru & Hubungan --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">No. HP Baru (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-whatsapp"></i></span>
                                    <input type="text" name="hp_manual" class="form-control" placeholder="Isi jika ganti nomor">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary small text-uppercase">Hubungan Keluarga</label>
                                <select name="hubungan" class="form-select" required>
                                    <option value="">-- Pilih Hubungan --</option>
                                    <option value="AYAH">AYAH</option>
                                    <option value="IBU">IBU</option>
                                    <option value="ISTRI">ISTRI</option>
                                    <option value="SUAMI">SUAMI</option>
                                    <option value="ANAK">ANAK</option>
                                    <option value="KAKAK">KAKAK</option>
                                    <option value="ADIK">ADIK</option>
                                    <option value="LAINNYA">LAINNYA</option>
                                </select>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('layanan.index') }}" class="btn btn-light px-4 border shadow-sm">
                                <i class="bi bi-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm fw-bold">
                                <i class="bi bi-save me-1"></i> Simpan Antrean
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-primary text-white mb-3" style="border-radius: 12px;">
                <div class="card-body">
                    <h6 class="fw-bold"><i class="bi bi-shuffle me-2"></i>Integrasi Database</h6>
                    <hr class="bg-white">
                    <ul class="small mb-0 ps-3">
                        <li class="mb-2">Data <strong>Tahanan</strong> berasal dari database <strong>Sipirman</strong>.</li>
                        <li class="mb-2">Data <strong>Keluarga</strong> berasal dari database <strong>Kagatau</strong>.</li>
                        <li class="mb-2">Tanggal Masuk otomatis sinkron dengan data Tahanan yang dipilih.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Select2 Assets --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi kedua Select2
        $('#tahanan_select, #penitip_select').select2({
            theme: 'bootstrap-5',
            allowClear: true,
            width: '100%'
        });
    });
</script>

<style>
    .select2-container--bootstrap-5 .select2-selection {
        border-radius: 8px;
        min-height: 45px;
        padding-top: 5px;
        border: 1px solid #dee2e6;
    }
    .input-group-text { border-radius: 8px 0 0 8px; }
    .form-control, .form-select { border-radius: 8px; }
</style>
@endsection