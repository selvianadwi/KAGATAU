@extends('layouts.main')
@section('title', 'Dashboard - KAGATAU')
@section('content')
<div class="container-fluid px-4">
    <div class="mt-4 mb-4 text-center">
        <h2 class="fw-bold text-dark text-uppercase">Layanan KAGATAU</h2>
        <p class="text-muted">Rutan Kelas IIB Rembang</p>
        <hr class="mx-auto" style="width: 80px; height: 4px; background-color: #0d6efd; border-radius: 2px;">
    </div>

    {{-- Fitur Atur Periode --}}
    <div class="card border-0 shadow-sm mb-4 rounded-4">
        <div class="card-body p-3">
            <form action="{{ route('dashboard') }}" method="GET" class="row g-2 align-items-end justify-content-center">
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">TANGGAL MULAI</label>
                    <input type="date" name="tgl_mulai" class="form-control form-control-sm" value="{{ $tgl_mulai }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">TANGGAL SELESAI</label>
                    <input type="date" name="tgl_selesai" class="form-control form-control-sm" value="{{ $tgl_selesai }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">
                        <i class="bi bi-filter"></i> FILTER DATA
                    </button>
                </div>
                <div class="col-md-1 text-center">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm" title="Reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Button Akses Cepat --}}
    <div class="row mb-4 justify-content-center">
        <div class="col-md-4 text-center">
            <a href="{{ route('layanan.create') }}" class="btn btn-primary btn-lg shadow-sm px-5 py-3 w-100 rounded-4">
                <i class="bi bi-plus-circle me-2"></i> INPUT LAYANAN BARU
            </a>
        </div>
    </div>

    {{-- Kotak Statistik --}}
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <a href="{{ route('tahanan.index') }}" class="text-decoration-none h-100 d-block card-stat">
                <div class="card border-0 shadow-sm text-white h-100" style="background: linear-gradient(45deg, #1a252f, #2c3e50); border-radius: 20px;">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-people-fill fs-1 mb-2"></i>
                        <h6 class="text-uppercase small fw-bold mb-2">Total Tahanan Masuk</h6>
                        <h1 class="display-4 fw-bold mb-0">{{ $totalTahanan }}</h1>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('layanan.index', ['status' => 'dilayani']) }}" class="text-decoration-none h-100 d-block card-stat">
                <div class="card border-0 shadow-sm text-white h-100" style="background: linear-gradient(45deg, #198754, #27ae60); border-radius: 20px;">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-check2-circle fs-1 mb-2"></i>
                        <h6 class="text-uppercase small fw-bold mb-2">Sudah Terlayani</h6>
                        <h1 class="display-4 fw-bold mb-0">{{ $terlayani }}</h1>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('layanan.index', ['status' => 'pending']) }}" class="text-decoration-none h-100 d-block card-stat">
                <div class="card border-0 shadow-sm text-white h-100" style="background: linear-gradient(45deg, #e74c3c, #c0392b); border-radius: 20px;">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-clock-history fs-1 mb-2"></i>
                        <h6 class="text-uppercase small fw-bold mb-2">Belum Terlayani</h6>
                        <h1 class="display-4 fw-bold mb-0">{{ $belumTerlayani }}</h1>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .card-stat { transition: transform 0.3s; }
    .card-stat:hover { transform: translateY(-10px); }
    .display-4 { letter-spacing: -2px; }
</style>
@endsection