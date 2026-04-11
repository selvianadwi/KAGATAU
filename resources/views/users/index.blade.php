@extends('layouts.main')

@section('title', 'Manajemen Petugas')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-0">Manajemen Petugas</h4>
            <p class="text-muted small mb-0">Kelola hak akses dan akun petugas Rutan Rembang</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm rounded-3">
            <i class="bi bi-person-plus-fill me-2"></i>Tambah Petugas
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 border-0">NAMA PETUGAS</th>
                        <th class="py-3 border-0">USERNAME</th>
                        <th class="py-3 border-0">HAK AKSES</th>
                        <th class="py-3 border-0">TANGGAL DAFTAR</th>
                        <th class="pe-4 py-3 border-0 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <span class="fw-semibold">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td>
                            <code class="text-primary fw-bold">@ {{ $u->username }}</code>
                        </td>
                        <td>
                            @if($u->role === 'admin')
                                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                    <i class="bi bi-shield-check me-1"></i> ADMIN
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">
                                    <i class="bi bi-person me-1"></i> PETUGAS
                                </span>
                            @endif
                        </td>
                        <td class="text-muted small">
                            {{ $u->created_at->format('d M Y') }}
                        </td>
                        <td class="pe-4 text-center">
                            <div class="btn-group">
                                <a href="{{ route('users.edit', $u->id) }}" class="btn btn-sm btn-outline-primary border-0 rounded-3">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                @if($u->id !== Auth::id())
                                <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-3" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada petugas terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 35px;
        height: 35px;
        background: linear-gradient(45deg, #3498db, #2980b9);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.9rem;
    }
    .bg-primary-subtle { background-color: rgba(52, 152, 219, 0.1); }
    .bg-secondary-subtle { background-color: rgba(108, 117, 125, 0.1); }
</style>
@endsection