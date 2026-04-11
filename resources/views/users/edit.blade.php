@extends('layouts.main')
@section('title', 'Edit Profil')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        {{-- Tombol Back Kecil di Atas --}}
        <div class="mb-3">
            <a href="javascript:history.back()" class="text-decoration-none text-muted small fw-bold">
                <i class="bi bi-arrow-left me-1"></i> KEMBALI
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Pengaturan Profil</h5>
                
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label small fw-bold">NAMA LENGKAP</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">USERNAME</label>
                        <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                    </div>

                    @if(Auth::user()->role === 'admin')
                    <div class="mb-3">
                        <label class="form-label small fw-bold">HAK AKSES (ROLE)</label>
                        <select name="role" class="form-select">
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>USER (PETUGAS)</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>ADMIN</option>
                        </select>
                    </div>
                    @endif

                    <hr class="my-4 opacity-50">
                    <p class="text-muted small">Kosongkan password jika tidak ingin mengganti.</p>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">PASSWORD BARU</label>
                        <input type="password" name="password" class="form-control" placeholder="Min. 6 Karakter">
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">KONFIRMASI PASSWORD</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                    </div>

                    <div class="d-flex gap-2">
                        {{-- Tombol Back Utama --}}
                        <a href="{{ url()->previous() }}" class="btn btn-light py-2 fw-bold flex-grow-1">
                            BATAL
                        </a>
                        <button type="submit" class="btn btn-primary py-2 fw-bold flex-grow-1">
                            SIMPAN PERUBAHAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection