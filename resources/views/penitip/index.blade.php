@extends('layouts.main')

@section('title', 'Data Keluarga')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Daftar Data Keluarga Tahanan</h4>
                <p class="text-muted small mb-0">Manajemen informasi pengunjung layanan Keluarga Tahanan KAGATAU</p>
            </div>
            <a href="{{ route('penitip.create') }}" class="btn btn-primary shadow-sm px-3">
                <i class="bi bi-plus-lg me-1"></i> Tambah Keluarga Tahanan
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-5 col-lg-4">
                <form action="{{ route('penitip.index') }}" method="GET">
                    <div class="input-group shadow-sm">
                        <input type="text" name="search" class="form-control border-secondary-subtle"
                            placeholder="Cari Nama atau NIK..." value="{{ request('search') }}">
                        <button class="btn btn-dark px-3" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                        @if (request('search'))
                            <a href="{{ route('penitip.index') }}" class="btn btn-outline-danger" title="Reset">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 mb-5" style="border-radius: 12px; overflow: hidden;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark text-nowrap">
                            <tr>
                                <th width="60" class="text-center py-3 border-0">No</th>
                                <th class="py-3 border-0 px-4">Nama</th>
                                <th class="py-3 border-0 text-center">NIK</th>
                                <th class="py-3 border-0 text-center">No. HP</th>
                                <th class="py-3 border-0 text-center">Foto Diri</th>
                                <th class="py-3 border-0 text-center">Foto KTP</th>
                                <th width="120" class="text-center py-3 border-0">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penitips as $p)
                                <tr>
                                    <td class="text-center text-muted small">
                                        {{ ($penitips->currentPage() - 1) * $penitips->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="fw-semibold text-dark px-4">{{ strtoupper($p->nama) }}</td>
                                    <td class="text-center">{{ $p->nik }}</td>
                                    <td class="text-center">{{ $p->hp ?? '-' }}</td>

                                    {{-- Kolom Foto Diri --}}
                                    <td class="text-center">
                                        @if ($p->foto)
                                            <button class="btn btn-outline-info btn-sm px-3 shadow-sm"
                                                data-bs-toggle="modal" data-bs-target="#mFoto{{ $p->id }}">
                                                <i class="bi bi-person-bounding-box"></i> Lihat
                                            </button>
                                            <div class="modal fade" id="mFoto{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow">
                                                        <div class="modal-header bg-light">
                                                            <h6 class="modal-title fw-bold text-dark">Foto Diri: {{ $p->nama }}</h6>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center p-4">
                                                            @php $pathF = str_contains($p->foto, 'foto_diri/') ? $p->foto : 'foto_diri/' . $p->foto; @endphp
                                                            <img src="{{ asset('storage/' . $pathF) }}" class="img-fluid rounded shadow" style="max-height: 400px; object-fit: contain;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>

                                    {{-- Kolom Foto KTP --}}
                                    <td class="text-center">
                                        @if ($p->foto_ktp)
                                            <button class="btn btn-outline-secondary btn-sm px-3 shadow-sm"
                                                data-bs-toggle="modal" data-bs-target="#mKtp{{ $p->id }}">
                                                <i class="bi bi-card-heading"></i> Lihat
                                            </button>
                                            <div class="modal fade" id="mKtp{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow">
                                                        <div class="modal-header bg-light">
                                                            <h6 class="modal-title fw-bold text-dark">Foto KTP: {{ $p->nama }}</h6>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center p-4">
                                                            @php $pathK = str_contains($p->foto_ktp, 'foto_ktp/') ? $p->foto_ktp : 'foto_ktp/' . $p->foto_ktp; @endphp
                                                            <img src="{{ asset('storage/' . $pathK) }}" class="img-fluid rounded shadow" style="max-height: 400px; object-fit: contain;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>

                                    {{-- Kolom Opsi (Tanpa WA) --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('penitip.edit', $p->id) }}"
                                                class="btn btn-warning btn-sm border-0 shadow-sm text-white" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('penitip.destroy', $p->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus data ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm border-0 shadow-sm" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted small">
                                        <i class="bi bi-search d-block fs-2 mb-2"></i> Data tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white py-3 d-flex justify-content-center border-top">
                <div class="pagination-clean">
                    {{ $penitips->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        #main-content { background-color: #f8f9fa; min-height: 100vh; }
        .table thead th { font-weight: 600; font-size: 0.85rem; background-color: #212529; vertical-align: middle !important; letter-spacing: 0.5px; }
        .table tbody td { vertical-align: middle !important; border-bottom: 1px solid #f0f2f5; }
        .table-hover tbody tr:hover { background-color: rgba(0, 0, 0, 0.02); }
        .pagination-clean nav div:first-child, .pagination-clean p { display: none !important; }
        .pagination-clean .pagination { margin-bottom: 0; gap: 5px; }
        .pagination-clean .page-link { padding: 6px 14px; border-radius: 8px !important; color: #333; border: 1px solid #dee2e6; }
        .pagination-clean .page-item.active .page-link { background-color: #212529 !important; border-color: #212529 !important; color: #fff !important; }
    </style>
@endsection