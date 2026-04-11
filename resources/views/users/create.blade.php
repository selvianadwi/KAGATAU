@extends('layouts.main')
@section('title', 'Tambah Petugas Baru')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Manajemen Petugas</a></li>
                <li class="breadcrumb-item active">Tambah Petugas</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-person-plus-fill text-primary me-2"></i>Tambah Petugas Baru</h5>
                
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">NAMA LENGKAP</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama lengkap petugas" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">USERNAME</label>
                        <input type="text" name="username" class="form-control" placeholder="Username untuk login" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">HAK AKSES (ROLE)</label>
                        <select name="role" class="form-select" required>
                            <option value="user" selected>USER (PETUGAS)</option>
                            <option value="admin">ADMIN (KEPALA/ADMIN)</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">PASSWORD</label>
                            <input type="password" name="password" class="form-control" placeholder="Min. 6 Karakter" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label small fw-bold">KONFIRMASI PASSWORD</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('users.index') }}" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Petugas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection