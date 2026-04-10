@extends('layouts.main')
@section('title', 'Data Layanan')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Daftar Layanan</h4>
                <p class="text-muted small mb-0">Manajemen data layanan KAGATAU (Database: Kagatau & Sipirman)</p>
            </div>
            <a href="{{ route('layanan.create') }}" class="btn btn-primary shadow-sm px-3">
                <i class="bi bi-plus-lg me-1"></i> Tambah Layanan Baru
            </a>
        </div>

        {{-- Form Filter & Pencarian --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-3">
                <form action="{{ route('layanan.index') }}" method="GET">
                    <div class="row g-2 align-items-end">
                        {{-- Cari Teks --}}
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Cari Data</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control border-start-0" 
                                       placeholder="Nama / NAPI..." value="{{ request('search') }}">
                            </div>
                        </div>

                        {{-- Filter Status --}}
                        <div class="col-md-2">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Status</label>
                            <select name="status" class="form-select">
                                <option value="">-- Semua --</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>PENDING</option>
                                <option value="dilayani" {{ request('status') == 'dilayani' ? 'selected' : '' }}>TERLAYANI</option>
                            </select>
                        </div>

                        {{-- Filter Tanggal Dari --}}
                        <div class="col-md-2">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Dari Tgl</label>
                            <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
                        </div>

                        {{-- Filter Tanggal Sampai --}}
                        <div class="col-md-2">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Sampai Tgl</label>
                            <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-dark w-100 fw-bold">FILTER</button>
                                <a href="{{ route('layanan.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </a>
                            </div>
                        </div>
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
                                <th class="text-center py-3">Status</th>
                                <th class="text-center py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($layanans as $l)
                                @php
                                    // 1. Ambil Identitas & Variabel untuk Tabel
                                    $namaT = $l->tahanan->nama ?? 'N/A';
                                    $codeNapi = $l->tahanan->code_napi ?? '-';
                                    $namaK = $l->keluarga->nama ?? 'N/A';
                                    $nomorTarget = $l->hp_manual ?? ($l->keluarga->hp ?? '-');

                                    // Variabel Baru: Tanggal Masuk dari tabel tahanan
                                    $tglMasukRaw = $l->tahanan->tanggal_masuk ?? null;
                                    $tglMasukFormatted = $tglMasukRaw ? \Carbon\Carbon::parse($tglMasukRaw)->format('d/m/Y') : '-';
                                    
                                    // 2. Logic Pesan WhatsApp
                                    $jsonPath = storage_path('app/wa_settings.json');
                                    $waSettings = file_exists($jsonPath) ? json_decode(file_get_contents($jsonPath), true) : [];
                                    
                                    // Template Pesan (Default jika JSON kosong)
                                    $msgTemplate = $waSettings['wa_template'] ?? "Halo Bapak/Ibu [nama_keluarga], kami dari Rutan Rembang menginfokan bahwa tahanan atas nama [nama_tahanan] telah tiba di Rutan pada tanggal [tanggal_masuk].";

                                    // Replace Variabel [nama_keluarga], [nama_tahanan], dan variabel baru [tanggal_masuk]
                                    $pesanFinal = str_replace(
                                        ['[nama_keluarga]', '[nama_tahanan]', '[tanggal_masuk]'],
                                        [strtoupper($namaK), strtoupper($namaT), $tglMasukFormatted],
                                        $msgTemplate
                                    );

                                    // 3. Format URL WhatsApp
                                    $nomorWA = preg_replace('/[^0-9]/', '', $nomorTarget);
                                    if (str_starts_with($nomorWA, '0')) { $nomorWA = '62' . substr($nomorWA, 1); }
                                    $urlWA = "https://api.whatsapp.com/send?phone=" . $nomorWA . "&text=" . urlencode($pesanFinal);
                                @endphp
                                <tr>
                                    <td class="text-center text-muted small">{{ ($layanans->currentPage() - 1) * $layanans->perPage() + $loop->iteration }}</td>
                                    <td class="text-center small">{{ $l->tanggal_masuk ? \Carbon\Carbon::parse($l->tanggal_masuk)->format('d/m/Y') : '-' }}</td>
                                    <td class="text-center text-nowrap small fw-bold">
                                        @if ($l->tanggal_layanan)
                                            <span class="text-primary">{{ \Carbon\Carbon::parse($l->tanggal_layanan)->format('d/m/Y H:i') }}</span>
                                        @else
                                            <span class="text-muted italic small">Belum Layanan</span>
                                        @endif
                                    </td>
                                    <td class="px-4">
                                        <div class="fw-bold text-dark">{{ strtoupper($namaT) }}</div>
                                        <div class="small text-muted" style="font-size: 0.7rem;">NAPI: {{ $codeNapi }}</div>
                                    </td>
                                    <td>{{ strtoupper($namaK) }}</td>
                                    <td class="text-center small">{{ $l->hubungan ?? '-' }}</td>
                                    <td class="text-center small">{{ $nomorTarget }}</td>
                                    <td class="text-center">
                                        @if ($l->screenshot)
                                            <button type="button" class="btn btn-sm btn-outline-info p-1" data-bs-toggle="modal" data-bs-target="#modalSS{{ $l->id }}"><i class="bi bi-image"></i></button>
                                            <div class="modal fade" id="modalSS{{ $l->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0"><div class="modal-body p-0"><img src="{{ asset('storage/' . $l->screenshot) }}" class="img-fluid rounded"></div></div></div>
                                            </div>
                                        @else <span class="text-muted small">-</span> @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($l->dokumentasi)
                                            <button type="button" class="btn btn-sm btn-outline-primary p-1" data-bs-toggle="modal" data-bs-target="#modalDok{{ $l->id }}"><i class="bi bi-camera"></i></button>
                                            <div class="modal fade" id="modalDok{{ $l->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0"><div class="modal-body p-0"><img src="{{ asset('storage/' . $l->dokumentasi) }}" class="img-fluid rounded"></div></div></div>
                                            </div>
                                        @else <span class="text-muted small">-</span> @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            @if ($l->status == 'pending')
                                                <span class="badge bg-warning text-dark px-2 py-1 small" style="font-size: 0.6rem;">PENDING</span>
                                            @else
                                                <span class="badge bg-success px-2 py-1 small" style="font-size: 0.6rem;">TERLAYANI</span>
                                            @endif
                                            <a href="{{ route('layanan.edit', $l->id) }}" class="btn btn-link btn-sm text-decoration-none p-0 fw-bold" style="font-size: 0.6rem;">UPDATE FOTO</a>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ $urlWA }}" target="_blank" onclick="setTimeout(function(){ window.location.href='{{ route('layanan.layani', $l->id) }}'; }, 500);" class="btn btn-outline-success btn-sm border-0"><i class="bi bi-whatsapp"></i></a>
                                            <a href="{{ route('layanan.edit2', $l->id) }}" class="btn btn-outline-primary btn-sm border-0"><i class="bi bi-pencil-square"></i></a>
                                            <form action="{{ route('layanan.destroy', $l->id) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="btn btn-outline-danger btn-sm border-0"><i class="bi bi-trash"></i></button></form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="11" class="text-center py-5 text-muted">Data tidak ditemukan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white d-flex justify-content-center">
                {{ $layanans->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection