@extends('layouts.main')
@section('title', 'Setting Pesan WA')

@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4 fw-bold">Setting Layanan KAGATAU</h4>
    <p class="text-muted small text-danger">*Data disimpan di file sistem (storage/app/wa_settings.json).</p>
    
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body">
            <form action="{{ route('setting.update') }}" method="POST" autocomplete="off">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Template Pesan WhatsApp</label>
                    <textarea 
                        name="wa_template" 
                        class="form-control @error('wa_template') is-invalid @enderror" 
                        rows="15" 
                        style="font-family: 'Courier New', Courier, monospace; font-size: 14px;"
                        placeholder="Contoh: Halo [nama_keluarga], tahanan [nama_tahanan] masuk pada [tanggal_masuk]..."
                    >{{ old('wa_template', $wa_template) }}</textarea>
                    
                    @error('wa_template')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="alert alert-info mt-3 py-2 border-0 small">
                        <strong>Variabel Pintar:</strong><br>
                        <code>[nama_keluarga]</code> -> Nama Keluarga (di tabel Penitip)<br>
                        <code>[nama_tahanan]</code> -> Nama Tahanan (di tabel Tahanan)<br>
                        <code>[tanggal_masuk]</code> -> Tanggal Masuk Tahanan (Format: dd/mm/yyyy)
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4 shadow-sm fw-bold">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection