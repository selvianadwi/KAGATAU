@extends('layouts.main')

@section('title', 'Dashboard - KAGATAU')

@section('content')
<div class="container-fluid px-4">
    {{-- Judul Besar --}}
    <div class="mt-4 mb-4 text-center">
        <h2 class="fw-bold text-dark">LAYANAN KABARI KELUARGA TAHANAN BARU</h2>
        <p class="text-muted">Sistem KAGATAU Rutan Rembang</p>
        <hr class="mx-auto" style="width: 100px; height: 4px; background-color: #0d6efd; border-radius: 2px;">
    </div>

    {{-- Button Akses Cepat --}}
    <div class="row mb-4 justify-content-center">
        <div class="col-md-4 text-center">
            <a href="{{ route('layanan.create') }}" class="btn btn-primary btn-lg shadow-sm px-5 py-3 w-100" style="border-radius: 15px;">
                <i class="bi bi-plus-circle me-2"></i> INPUT LAYANAN BARU
            </a>
        </div>
    </div>

    {{-- Kotak Statistik Besar --}}
    <div class="row g-4 justify-content-center">
        {{-- Card Total Tahanan - Ke Data Tahanan --}}
        <div class="col-md-4">
            <a href="{{ route('tahanan.index') }}" class="text-decoration-none h-100 d-block">
                <div class="card border-0 shadow-sm text-white h-100" style="background: linear-gradient(45deg, #212529, #495057); border-radius: 20px;">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-people-fill fs-1 mb-3 d-block"></i>
                        <h6 class="text-uppercase fw-bold mb-2">Total Tahanan Masuk</h6>
                        <h1 class="display-3 fw-bold mb-0">{{ $totalTahanan }}</h1>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4 text-center">
                        <div class="small opacity-75">Klik untuk lihat data tahanan</div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Card Terlayani - Filter Status Dilayani --}}
        <div class="col-md-4">
            <a href="{{ route('layanan.index', ['status' => 'dilayani']) }}" class="text-decoration-none h-100 d-block">
                <div class="card border-0 shadow-sm text-white h-100" style="background: linear-gradient(45deg, #198754, #2ecc71); border-radius: 20px;">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-check2-circle fs-1 mb-3 d-block"></i>
                        <h6 class="text-uppercase fw-bold mb-2">Sudah Terlayani</h6>
                        <h1 class="display-3 fw-bold mb-0">{{ $terlayani }}</h1>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4 text-center">
                        <div class="small opacity-75">Klik untuk lihat yang terlayani</div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Card Belum Terlayani - Filter Status Pending --}}
        <div class="col-md-4">
            <a href="{{ route('layanan.index', ['status' => 'pending']) }}" class="text-decoration-none h-100 d-block">
                <div class="card border-0 shadow-sm text-white h-100" style="background: linear-gradient(45deg, #dc3545, #ff4757); border-radius: 20px;">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-clock-history fs-1 mb-3 d-block"></i>
                        <h6 class="text-uppercase fw-bold mb-2">Belum Terlayani</h6>
                        <h1 class="display-3 fw-bold mb-0">{{ $belumTerlayani }}</h1>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4 text-center">
                        <div class="small opacity-75">Klik untuk lihat antrean pending</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Link Cepat ke Data --}}
    <div class="row mt-5">
        <div class="col-12 text-center">
            <a href="{{ route('layanan.index') }}" class="text-decoration-none text-secondary fw-bold">
                <i class="bi bi-list-task me-1"></i> LIHAT SEMUA DAFTAR ANTREAN
            </a>
        </div>
    </div>
</div>

<style>
    /* Agar cursor berubah jadi pointer karena dibungkus anchor */
    a.text-decoration-none:hover .card {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2) !important;
        cursor: pointer;
    }
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .display-3 {
        letter-spacing: -2px;
    }
</style>
@endsection