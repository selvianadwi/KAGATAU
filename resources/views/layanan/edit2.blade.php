@extends('layouts.main')
@section('title', 'Edit Data Antrean')

@section('content')
<div class="container-fluid px-4">
    <div class="mt-4 mb-3">
        <h4 class="fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Informasi Antrean</h4>
        <p class="text-muted small">Mengubah data relasi Tahanan dan Keluarga untuk antrean #{{ $layanan->id }}</p>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <form action="{{ route('layanan.update', $layanan->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    {{-- Pilih Tahanan (Sipirman) --}}
                    <div class="col-md-12 mb-4">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Pilih Tahanan (WBP)</label>
                        <select name="tahanan_id" class="form-select select2" required>
                            @foreach($tahanans as $t)
                                <option value="{{ $t->id }}" {{ $layanan->tahanan_id == $t->id ? 'selected' : '' }}>
                                    {{ strtoupper($t->nama) }} — [{{ $t->code_napi }}]
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pilih Keluarga (Sipirman) --}}
                    <div class="col-md-12 mb-4">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Pilih Keluarga (Pengunjung)</label>
                        <select name="penitip_id" class="form-select select2" required>
                            @foreach($keluargas as $k)
                                <option value="{{ $k->id }}" {{ $layanan->penitip_id == $k->id ? 'selected' : '' }}>
                                    {{ strtoupper($k->nama) }} — [NIK: {{ $k->nik }}]
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold small text-uppercase text-secondary">No. HP Baru (Opsional)</label>
                        <input type="text" name="hp_manual" class="form-control" value="{{ $layanan->hp_manual }}" placeholder="0812...">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Hubungan</label>
                        <select name="hubungan" class="form-select" required>
                            @foreach(['AYAH', 'IBU', 'ISTRI', 'SUAMI', 'ANAK', 'KAKAK', 'ADIK', 'LAINNYA'] as $o)
                                <option value="{{ $o }}" {{ $layanan->hubungan == $o ? 'selected' : '' }}>{{ $o }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('layanan.index') }}" class="btn btn-light border px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">SIMPAN PERUBAHAN DATA</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Assets Select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({ theme: 'bootstrap-5', width: '100%' });
    });
</script>
@endsection