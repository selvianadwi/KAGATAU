@extends('layouts.main')
@section('title', 'Manajemen PIN Saku WBP')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
            <h4 class="fw-bold mb-0 text-dark">Manajemen PIN Saku WBP</h4>
            <p class="text-muted small mb-0">Pengaturan kode akses mandiri warga binaan Rutan Rembang</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-5 col-lg-4">
            <form action="{{ route('pin-saku.index') }}" method="GET">
                <div class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control border-secondary-subtle"
                        placeholder="Cari Nama WBP" value="{{ request('search') }}">
                    <button class="btn btn-dark px-3" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <div class="card shadow-sm border-0 mb-5" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="60" class="text-center py-3 border-0">No</th>
                            <th class="py-3 border-0 px-4">Nama WBP</th>
                            <th class="py-3 border-0 text-center">PIN Aktif</th>
                            <th width="200" class="text-center py-3 border-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tahanans as $t)
                        <tr>
                            <td class="text-center text-muted small">
                                {{ ($tahanans->currentPage() - 1) * $tahanans->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-4 fw-bold">
                                {{ strtoupper($t->nama) }}
                                <div class="text-muted small fw-normal">Bin {{ strtoupper($t->nama_ayah) }}</div>
                            </td>
                            {{-- Ganti bagian kolom PIN Aktif di dalam tabel --}}
<td class="text-center">
    @if($t->pin)
        <div class="d-flex align-items-center justify-content-center gap-2">
            {{-- Menampilkan sensor titik-titik --}}
            <span class="fw-bold text-secondary fs-5" style="letter-spacing: 3px;">••••••</span>
            <i class="bi bi-shield-fill-check text-success" title="Terenskripsi MD5"></i>
        </div>
    @else
        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3">
            <i class="bi bi-x-circle me-1"></i> BELUM SET
        </span>
    @endif
</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalPin{{ $t->id }}">
                                    <i class="bi bi-key-fill me-1"></i> Atur PIN
                                </button>
                            </td>
                        </tr>

                       <div class="modal fade" id="modalPin{{ $t->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pin-saku.update', $t->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body text-center pt-0">
                    <div class="mb-3">
                        <i class="bi bi-shield-lock-fill text-primary display-4"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Update PIN Saku</h6>
                    <p class="small text-muted mb-4">{{ strtoupper($t->nama) }}</p>
                    
                    <label class="form-label small fw-bold text-muted text-uppercase">Input PIN Baru (6 Digit Angka)</label>
                    <input type="password" 
       name="pin" 
       class="form-control form-control-lg text-center fw-bold bg-light border-0" 
       placeholder="••••••" 
       maxlength="6" 
       minlength="6" 
       pattern="\d{6}"
       title="PIN harus tepat 6 angka"
       inputmode="numeric"
       oninput="this.value = this.value.replace(/[^0-9]/g, '');"
       required>
<div class="form-text mt-2" style="font-size: 0.7rem;">
    <i class="bi bi-info-circle me-1"></i>PIN akan otomatis dienkripsi setelah disimpan.
</div>
                </div>
                <div class="modal-footer border-0 p-3">
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-3">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Data tidak ditemukan.</td>
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
    .pagination-clean nav div:first-child, .pagination-clean p { display: none !important; }
    .pagination-clean .pagination { margin-bottom: 0; gap: 5px; }
    .pagination-clean .page-link { padding: 6px 14px; border-radius: 8px !important; color: #333; border: 1px solid #dee2e6; }
    .pagination-clean .page-item.active .page-link { background-color: #212529 !important; border-color: #212529 !important; color: #fff !important; }
</style>
@endsection