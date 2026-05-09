@extends('layouts.main')

@section('title', 'Data Tahanan')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Daftar Data Tahanan</h4>
                <p class="text-muted small mb-0">Manajemen informasi warga binaan sistem KAGATAU</p>
            </div>
            <a href="{{ route('tahanan.create') }}" class="btn btn-primary shadow-sm px-3">
                <i class="bi bi-plus-lg me-1"></i> Tambah Tahanan
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-5 col-lg-4">
                <form action="{{ route('tahanan.index') }}" method="GET">
                    <div class="input-group shadow-sm">
                        <input type="text" name="search" class="form-control border-secondary-subtle"
                            placeholder="Cari Nama atau Code NAPI..." value="{{ request('search') }}">
                        <button class="btn btn-dark px-3" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                        @if (request('search'))
                            <a href="{{ route('tahanan.index') }}" class="btn btn-outline-danger" title="Reset">
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
                                <th class="py-3 border-0 px-4">Kode Tahanan</th>
                                <th class="py-3 border-0">Nama Lengkap</th>
                                <th class="py-3 border-0">Nama Ayah</th>
                                <th class="py-3 border-0 text-center">Jenis Kelamin</th>
                                <th width="140" class="text-center py-3 border-0">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tahanans as $t)
                                <tr>
                                    <td class="text-center text-muted small">
                                        {{ ($tahanans->currentPage() - 1) * $tahanans->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-4">
                                        <span class="fw-semibold text-dark">
                                            {{ $t->code_napi }}
                                        </span>
                                    </td>
                                    <td class="fw-semibold text-dark">
                                        {{ strtoupper($t->nama) }}
                                        @if ($t->nama_ayah)
                                            {{ $t->jenis_kelamin == 'Wanita' ? 'Binti' : 'Bin' }}
                                            {{ strtoupper($t->nama_ayah) }}
                                        @endif
                                    </td>
                                    <td>{{ strtoupper($t->nama_ayah) }}</td>
                                    <td class="text-center">
                                        @if ($t->jenis_kelamin == 'Pria')
                                            <span
                                                class="badge bg-primary-subtle text-primary border-primary-subtle px-3 py-2 rounded-pill">
                                                <i class="bi bi-gender-male me-1"></i> {{ $t->jenis_kelamin }}
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-danger-subtle text-danger border-danger-subtle px-3 py-2 rounded-pill">
                                                <i class="bi bi-gender-female me-1"></i> {{ $t->jenis_kelamin }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('tahanan.edit', $t->id) }}"
                                                class="btn btn-warning btn-sm text-white border-0 shadow-sm"
                                                title="Edit Data">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form action="{{ route('tahanan.destroy', $t->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data tahanan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm border-0 shadow-sm"
                                                    title="Hapus Data">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted small">
                                            <i class="bi bi-person-x fs-1 mb-3 d-block opacity-50"></i>
                                            @if (request('search'))
                                                <p class="mb-1">Pencarian "<strong>{{ request('search') }}</strong>"
                                                    tidak ditemukan.</p>
                                                <a href="{{ route('tahanan.index') }}"
                                                    class="text-primary text-decoration-none fw-bold small">Tampilkan semua
                                                    data</a>
                                            @else
                                                <p class="mb-0">Belum ada data tahanan yang tersimpan.</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($tahanans->hasPages())
                <div class="card-footer bg-white py-3 d-flex justify-content-center border-top">
                    <div class="pagination-clean">
                        {{ $tahanans->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Dasar Layout */
        #main-content {
            padding-top: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        /* Tabel Header */
        .table thead th {
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            background-color: #212529;
            vertical-align: middle !important;
            text-transform: uppercase;
        }

        /* Tabel Body */
        .table tbody td {
            vertical-align: middle !important;
            border-bottom: 1px solid #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        /* Badge & Form */
        .badge {
            font-weight: 500;
            border: 1px solid transparent;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }

        /* Pagination Clean Up */
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
