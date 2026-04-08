@extends('layouts.main')
@section('title', 'Data Layanan')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Daftar Antrean Layanan</h4>
                <p class="text-muted small mb-0">Manajemen data layanan KAGATAU (Database: Kagatau & Sipirman)</p>
            </div>
            <a href="{{ route('layanan.create') }}" class="btn btn-primary shadow-sm px-3">
                <i class="bi bi-plus-lg me-1"></i> Tambah Layanan Baru
            </a>
        </div>

        {{-- Form Pencarian --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <form action="{{ route('layanan.index') }}" method="GET">
                    <div class="input-group shadow-sm">
                        <input type="text" name="search" class="form-control border-secondary-subtle" 
                               placeholder="Cari Tahanan atau Keluarga..." value="{{ request('search') }}">
                        <button class="btn btn-dark px-3" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark text-nowrap">
                            <tr>
                                <th class="text-center py-3">No</th>
                                <th class="text-center py-3">Tgl Masuk</th>
                                <th class="text-center py-3">Tgl Layanan</th>
                                <th class="py-3 px-4">Nama Tahanan (WBP)</th>
                                <th class="py-3">Nama Keluarga</th>
                                <th class="text-center py-3">Hubungan</th>
                                <th class="text-center py-3">No. HP</th>
                                <th class="text-center py-3">Screenshot</th>
                                <th class="text-center py-3">Dokumentasi</th>
                                <th class="text-center py-3">Status & Update</th>
                                <th class="text-center py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($layanans as $l)
                                @php
                                    // 1. Ambil Data Tahanan & Keluarga dengan aman
                                    $namaT = $l->tahanan->nama ?? 'N/A';
                                    $codeNapi = $l->tahanan->code_napi ?? '-';
                                    $namaK = $l->keluarga->nama ?? 'N/A';
                                    
                                    // 2. Logic WhatsApp
                                    $nomorTarget = $l->hp_manual ?? ($l->keluarga->hp ?? '-');
                                    $jsonPath = storage_path('app/wa_settings.json');
                                    $waSettings = file_exists($jsonPath) ? json_decode(file_get_contents($jsonPath), true) : [];
                                    $rawMessage = $waSettings['wa_template'] ?? 'Layanan KAGATAU: Tahanan [nama_tahanan]...';
                                    
                                    $pesanFinal = str_replace(['[nama_keluarga]', '[nama_tahanan]'], [strtoupper($namaK), strtoupper($namaT)], $rawMessage);
                                    $nomorWA = preg_replace('/[^0-9]/', '', $nomorTarget);
                                    if (str_starts_with($nomorWA, '0')) $nomorWA = '62' . substr($nomorWA, 1);
                                    $urlWA = 'https://api.whatsapp.com/send?phone=' . $nomorWA . '&text=' . urlencode($pesanFinal);
                                @endphp
                                <tr>
                                    <td class="text-center text-muted small">{{ $loop->iteration }}</td>
                                    
                                    {{-- Tgl Masuk (Dari Tahanan) --}}
                                    <td class="text-center small">
                                        {{ $l->tanggal_masuk ? \Carbon\Carbon::parse($l->tanggal_masuk)->format('d/m/Y') : '-' }}
                                    </td>

                                    {{-- Tgl Layanan (Otomatis saat Layani) --}}
                                    <td class="text-center text-nowrap small">
                                        @if($l->tanggal_layanan)
                                            {{ \Carbon\Carbon::parse($l->tanggal_layanan)->format('d/m/Y H:i') }}
                                        @else
                                            <span class="text-muted italic">Menunggu...</span>
                                        @endif
                                    </td>

                                    {{-- NAMA TAHANAN (REF: TABEL TAHANAN) --}}
                                    <td class="px-4">
                                        <div class="fw-bold text-dark">{{ strtoupper($namaT) }}</div>
                                        <div class="small text-muted" style="font-size: 0.7rem;">NAPI: {{ $codeNapi }}</div>
                                    </td>

                                    {{-- NAMA KELUARGA (REF: TABEL PENITIP) --}}
                                    <td>{{ strtoupper($namaK) }}</td>

                                    <td class="text-center small">{{ $l->hubungan ?? '-' }}</td>
                                    <td class="text-center small">{{ $nomorTarget }}</td>

                                    {{-- Kolom Screenshot --}}
                                    <td class="text-center">
                                        @if ($l->screenshot)
                                            <button type="button" class="btn btn-sm btn-outline-info px-2 py-1" data-bs-toggle="modal" data-bs-target="#modalSS{{ $l->id }}">
                                                <i class="bi bi-image"></i> Lihat
                                            </button>
                                            <div class="modal fade" id="modalSS{{ $l->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0"><div class="modal-header bg-info text-white"><h6 class="modal-title">Screenshot WA</h6><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><div class="modal-body bg-light text-center"><img src="{{ asset('storage/' . $l->screenshot) }}" class="img-fluid rounded shadow-sm" style="max-height: 70vh; object-fit: contain;"></div></div></div>
                                            </div>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle small">Belum</span>
                                        @endif
                                    </td>

                                    {{-- Kolom Dokumentasi --}}
                                    <td class="text-center">
                                        @if ($l->dokumentasi)
                                            <button type="button" class="btn btn-sm btn-outline-primary px-2 py-1" data-bs-toggle="modal" data-bs-target="#modalDok{{ $l->id }}">
                                                <i class="bi bi-camera"></i> Lihat
                                            </button>
                                            <div class="modal fade" id="modalDok{{ $l->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0"><div class="modal-header bg-primary text-white"><h6 class="modal-title">Foto Dokumentasi</h6><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><div class="modal-body bg-light text-center"><img src="{{ asset('storage/' . $l->dokumentasi) }}" class="img-fluid rounded shadow-sm" style="max-height: 70vh; object-fit: contain;"></div></div></div>
                                            </div>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle small">Belum</span>
                                        @endif
                                    </td>

                                    {{-- Status & Update --}}
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            @if ($l->status == 'pending')
                                                <span class="badge bg-warning text-dark px-2 py-1 small mb-1">PENDING</span>
                                            @else
                                                <span class="badge bg-success px-2 py-1 small mb-1">TERLAYANI</span>
                                            @endif
                                            <a href="{{ route('layanan.edit', $l->id) }}" class="btn btn-link btn-sm text-decoration-none p-0 text-primary fw-bold" style="font-size: 0.7rem;">
                                                <i class="bi bi-cloud-arrow-up-fill me-1"></i>Update Foto
                                            </a>
                                        </div>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ $urlWA }}" target="_blank"
                                                onclick="setTimeout(function(){ window.location.href='{{ route('layanan.layani', $l->id) }}'; }, 500);"
                                                class="btn btn-success btn-sm shadow-sm" title="Layani via WA">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>
                                            <form action="{{ route('layanan.destroy', $l->id) }}" method="POST" onsubmit="return confirm('Hapus antrean ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm border-0"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="11" class="text-center py-5 text-muted small italic">Belum ada antrean hari ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white d-flex justify-content-center">
                {{ $layanans->links() }}
            </div>
        </div>
    </div>
@endsection