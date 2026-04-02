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
                           placeholder="Cari Nama atau Code NAPI..." 
                           value="{{ request('search') }}">
                    <button class="btn btn-dark px-3" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('tahanan.index') }}" class="btn btn-outline-danger" title="Reset">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
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
                            <th class="py-3 border-0">Kode Tahanan</th>
                            <th class="py-3 border-0">Nama</th>
                            <th class="py-3 border-0">Nama Ayah</th>
                            <th class="py-3 border-0">Jenis Kelamin</th>
                            <th width="120" class="text-center py-3 border-0">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tahanans as $index => $t)
                        <tr>
                            <td class="text-center text-muted">{{ $index + 1 }}</td>
                            
                            <td class="text-dark">{{ $t->code_napi }}</td>
                            
                            <td class="fw-semibold text-dark">{{ $t->nama }}</td>
                            <td>{{ $t->nama_ayah }}</td>
                            <td>
                                @if($t->jenis_kelamin == 'Pria')
                                    <i class="bi bi-gender-male text-primary me-1"></i>
                                @else
                                    <i class="bi bi-gender-female text-danger me-1"></i>
                                @endif
                                {{ $t->jenis_kelamin }}
                            </td>
                            
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="#" class="btn btn-warning btn-sm border-0 shadow-sm text-white" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('tahanan.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data tahanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm border-0 shadow-sm" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-search fs-1 mb-3 d-block"></i>
                                    @if(request('search'))
                                        <p class="mb-0">Pencarian untuk "<strong>{{ request('search') }}</strong>" tidak ditemukan.</p>
                                        <a href="{{ route('tahanan.index') }}" class="text-primary text-decoration-none small">Kembali ke semua data</a>
                                    @else
                                        <p class="mb-0">Data tahanan belum tersedia.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling agar tampilan konsisten */
    #main-content {
        padding-top: 20px;
        background-color: #f8f9fa;
        min-height: 100vh;
    }
    
    .table thead th {
        font-weight: 500;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        background-color: #212529;
    }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #0d6efd;
    }

    .card {
        background-color: #ffffff;
    }
</style>
@endsection