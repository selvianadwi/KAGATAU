@extends('layouts.main')
@section('title', 'Tambah Layanan')

@section('content')
<div class="container-fluid px-4">
    <div class="mt-4 mb-3">
        <h4 class="fw-bold text-dark">Input Data Layanan Baru</h4>
        <p class="text-muted small">Pilih data keluarga untuk mendaftarkan layanan antrean.</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <form action="{{ route('layanan.store') }}" method="POST" autocomplete="off">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Layanan</label>
                                <input type="date" name="tanggal_layanan" class="form-control" 
                                       value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">No. HP Baru (Opsional)</label>
                                <input type="text" name="hp_manual" class="form-control" 
                                       placeholder="Isi jika keluarga ganti nomor">
                                <div class="form-text small text-info">Kosongkan jika ingin menggunakan nomor terdaftar.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Keluarga Tahanan</label>
                            <select name="penitip_id" id="penitip_select" class="form-select select2" required>
                                <option value="">-- Cari Nama Keluarga atau Tahanan --</option>
                                @foreach($keluargas as $k)
                                    <option value="{{ $k->id }}">
                                        {{ strtoupper($k->nama) }} — [Tahanan: {{ strtoupper($k->nama_wbp) }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Hubungan Keluarga</label>
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
                            <div class="form-text small">Tentukan hubungan orang tersebut dengan tahanan.</div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('layanan.index') }}" class="btn btn-light px-4 border">Batal</a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">Simpan Data Layanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="alert alert-info border-0 shadow-sm">
                <h6 class="fw-bold"><i class="bi bi-info-circle me-2"></i>Informasi Otomatis</h6>
                <ul class="small mb-0 ps-3">
                    <li><strong>No Antrean</strong> akan dibuat otomatis oleh sistem.</li>
                    <li><strong>Tanggal Masuk</strong> dicatat sesuai waktu saat ini (Real-time).</li>
                    <li><strong>Status Awal</strong> akan diset menjadi <span class="badge bg-warning text-dark">PENDING</span>.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#penitip_select').select2({
            theme: 'bootstrap-5',
            placeholder: "-- Cari Nama Keluarga atau Tahanan --",
            allowClear: true
        });
    });
</script>

<style>
    .select2-container--bootstrap-5 .select2-selection {
        border-radius: 8px;
        height: calc(3.5rem + 2px);
        padding: 0.75rem 1rem;
    }
</style>
@endsection