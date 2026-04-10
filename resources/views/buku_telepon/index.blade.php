@extends('layouts.main')
@section('title', 'Buku Telepon - Tracing')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-telephone-plus-fill me-2 text-success"></i>Buku Telepon & Tracing WBP
            </h4>
            <p class="text-muted small mb-0">Pemetaan nomor telepon keluarga berdasarkan riwayat Layanan KAGATAU dan Sipirman.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-white text-dark border shadow-sm px-3 py-2">
                <i class="bi bi-person-lines-fill me-1 text-primary"></i> Total Tahanan: {{ $tahanans->total() }}
            </span>
        </div>
    </div>

    {{-- Form Pencarian --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body p-3">
            <form action="{{ route('buku-telepon.index') }}" method="GET">
                <div class="row g-2">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0" 
                                   placeholder="Cari Nama Tahanan atau Kode Napi..." value="{{ request('search') }}">
                            <button class="btn btn-primary px-4" type="submit">Cari Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-dark text-nowrap text-center">
                        <tr>
                            <th class="py-3" style="width: 50px;">NO</th>
                            <th class="py-3" style="width: 250px;">NAMA TAHANAN</th>
                            <th class="py-3">NAMA KELUARGA</th>
                            <th class="py-3">HUBUNGAN</th>
                            <th class="py-3">NOMOR TELEPON</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tahanans as $index => $t)
                            @php 
                                $rowcount = count($t->semua_keluarga); 
                                $firstRow = true;
                            @endphp

                            @if($rowcount > 0)
                                @foreach($t->semua_keluarga as $kel)
                                @php
                                    $noWA = preg_replace('/[^0-9]/', '', $kel->hp);
                                    if (str_starts_with($noWA, '0')) { $noWA = '62' . substr($noWA, 1); }
                                @endphp
                                <tr>
                                    @if($firstRow)
                                        <td class="text-center fw-bold text-muted" rowspan="{{ $rowcount }}">
                                            {{ $tahanans->firstItem() + $index }}
                                        </td>
                                        <td class="px-3 border-end" rowspan="{{ $rowcount }}">
                                            <div class="fw-bold text-dark fs-6">{{ strtoupper($t->nama) }}</div>
                                            <div class="small text-muted">ID: {{ $t->code_napi }}</div>
                                        </td>
                                        @php $firstRow = false; @endphp
                                    @endif
                                    
                                    <td class="ps-3 fw-bold text-dark">
                                        <i class=" me-1 text-muted"></i> {{ strtoupper($kel->nama_keluarga) }}
                                    </td>
                                    <td class="text-center text-muted small">{{ $kel->hubungan ?? 'Keluarga' }}</td>
                                    <td class="text-center">
                                        @if($kel->hp && $kel->hp != '-')
                                            <a href="https://wa.me/{{ $noWA }}" target="_blank" class="text-success fw-bold text-decoration-none">
                                                <i class="bi bi-whatsapp me-1"></i>{{ $kel->hp }}
                                            </a>
                                        @else 
                                            <span class="text-muted italic small">Tidak Ada</span> 
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                {{-- Jika tahanan tidak punya keluarga sama sekali --}}
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $tahanans->firstItem() + $index }}</td>
                                    <td class="px-3">
                                        <div class="fw-bold text-dark fs-6">{{ strtoupper($t->nama) }}</div>
                                        <div class="small text-muted">ID: {{ $t->code_napi }}</div>
                                    </td>
                                    <td colspan="3" class="text-center text-muted small italic py-3">
                                        Belum ada data keluarga yang terafiliasi.
                                    </td>
                                </tr>
                            @endif
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted italic">Data tahanan tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
            {{ $tahanans->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<style>
    .table-bordered th, .table-bordered td { border-color: #dee2e6 !important; }
    .italic { font-style: italic; }
</style>
@endsection