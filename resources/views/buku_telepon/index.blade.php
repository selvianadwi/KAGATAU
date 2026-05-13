@extends('layouts.main')
@section('title', 'Buku Telepon - Tracing')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">
                    <i class="bi bi-telephone-plus-fill me-2 text-success"></i>Buku Telepon & Tracing WBP
                </h4>
                <p class="text-muted small mb-0">Pemetaan nomor telepon keluarga berdasarkan riwayat Layanan KAGATAU dan
                    Sipirman.</p>
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
                                <span class="input-group-text bg-white border-end-0"><i
                                        class="bi bi-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control border-start-0"
                                    placeholder="Nama Tahanan, Keluarga, atau Kode Napi..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-primary px-4" type="submit">Cari Data</button>
                                @if (request('search'))
                                    <a href="{{ route('buku-telepon.index') }}" class="btn btn-outline-danger" title="Reset">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-5" style="border-radius: 15px; overflow: hidden;">
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

                                @if ($rowcount > 0)
                                    @foreach ($t->semua_keluarga as $kel)
                                        @php
                                            $noWA = preg_replace('/[^0-9]/', '', $kel->hp);
                                            if (str_starts_with($noWA, '0')) {
                                                $noWA = '62' . substr($noWA, 1);
                                            }
                                        @endphp
                                        <tr>
                                            @if ($firstRow)
                                                <td class="text-center fw-bold text-muted" rowspan="{{ $rowcount }}">
                                                    {{ ($tahanans->currentPage() - 1) * $tahanans->perPage() + $loop->parent->iteration }}
                                                </td>
                                                <td class="px-3 border-end" rowspan="{{ $rowcount }}">
                                                    @php
                                                        $namaAyah = $t->nama_ayah ?? null;
                                                        $jk = strtoupper($t->jk ?? ''); 

                                                        $binBinti = ($jk === 'P' || $jk === 'PEREMPUAN' || $t->jenis_kelamin == 'Wanita') ? 'BINTI' : 'BIN';

                                                        $namaTampil = $namaAyah
                                                            ? strtoupper($t->nama) . ' ' . $binBinti . ' ' . strtoupper($namaAyah)
                                                            : strtoupper($t->nama);
                                                    @endphp

                                                    <div class="fw-bold text-dark fs-6">{{ $namaTampil }}</div>
                                                </td>
                                                @php $firstRow = false; @endphp
                                            @endif

                                            <td class="ps-3 fw-bold text-dark">
                                                {{ strtoupper($kel->nama_keluarga) }}
                                            </td>
                                            <td class="text-center text-muted small">{{ $kel->hubungan ?? 'Keluarga' }}
                                            </td>
                                            <td class="text-center">
                                                @if ($kel->hp && $kel->hp != '-')
                                                    <a href="https://wa.me/{{ $noWA }}" target="_blank"
                                                        class="text-success fw-bold text-decoration-none">
                                                        <i class="bi bi-whatsapp me-1"></i>{{ $kel->hp }}
                                                    </a>
                                                @else
                                                    <span class="text-muted italic small">Tidak Ada</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center fw-bold text-muted">
                                             {{ ($tahanans->currentPage() - 1) * $tahanans->perPage() + $loop->iteration }}
                                        </td>
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
                                    <td colspan="5" class="text-center py-5 text-muted italic">Data tahanan tidak
                                        ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination ala Index Tahanan --}}
            @if ($tahanans->hasPages())
                <div class="card-footer bg-white py-3 d-flex justify-content-center border-top">
                    <div class="pagination-clean">
                        {{ $tahanans->appends(request()->query())->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .table-bordered th,
        .table-bordered td {
            border-color: #dee2e6 !important;
        }

        .italic {
            font-style: italic;
        }

        /* Pagination Clean Up (Sesuai Index Tahanan) */
        .pagination-clean nav div:first-child,
        .pagination-clean p {
            display: none !important;
        }

        .pagination-clean .pagination {
            margin-bottom: 0;
            gap: 5px;
        }

        .pagination-clean .page-link {
            padding: 6px 14px;
            border-radius: 8px !important;
            color: #333;
            border: 1px solid #dee2e6;
        }

        .pagination-clean .page-item.active .page-link {
            background-color: #212529 !important;
            border-color: #212529 !important;
            color: #fff !important;
        }
    </style>
@endsection