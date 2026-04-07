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
                                <th class="py-3 border-0">No. HP</th>
                                <th class="py-3 border-0 text-center">Foto Diri</th>
                                <th class="py-3 border-0 text-center">Foto KTP</th>
                                <th width="160" class="text-center py-3 border-0">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penitips as $p)
                                @php
                                    // 1. Ambil Template
                                    $jsonPath = storage_path('app/wa_settings.json');
                                    $waSettings = file_exists($jsonPath)
                                        ? json_decode(file_get_contents($jsonPath), true)
                                        : [];
                                    $rawMessage =
                                        $waSettings['wa_template'] ??
                                        "Layanan KAGATAU.\nYth. [nama_keluarga], tahanan [nama_tahanan] telah di Rutan.";

                                    // 2. LOGIKA PEMBERSIHAN TOTAL (PENTING!)
                                    $namaRaw = $p->nama_wbp;

                                    // Jika ternyata array, ambil elemen pertama
                                    if (is_array($namaRaw)) {
                                        $namaTahanan = $namaRaw[0];
                                    } else {
                                        // Jika string tapi isinya format JSON (ada [" "]), decode dulu
                                        $decoded = json_decode($namaRaw, true);
                                        if (is_array($decoded)) {
                                            $namaTahanan = $decoded[0];
                                        } else {
                                            // Jika string biasa, buang karakter [ ] dan " secara manual (antisipasi terakhir)
        $namaTahanan = str_replace(['[', ']', '"'], '', $namaRaw);
    }
}

$namaKeluarga = str_replace(['[', ']', '"'], '', (string) $p->nama);

// 3. Replace ke Template
$pesanFinal = str_replace(
    ['[nama_keluarga]', '[nama_tahanan]'],
    [strtoupper(trim($namaKeluarga)), strtoupper(trim($namaTahanan))],
    $rawMessage,
);

// 4. Format Nomor & URL (Tetap sama)
$nomorBersih = preg_replace('/[^0-9]/', '', $p->hp);
$nomorWA = str_starts_with($nomorBersih, '0')
    ? '62' . substr($nomorBersih, 1)
    : (str_starts_with($nomorBersih, '62')
        ? $nomorBersih
        : '62' . $nomorBersih);
$urlWA =
    'https://api.whatsapp.com/send?phone=' .
    $nomorWA .
    '&text=' .
                                        urlencode($pesanFinal);
                                @endphp
                                <tr>
                                    <td class="text-center text-muted small">
                                        {{ ($penitips->currentPage() - 1) * $penitips->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="fw-semibold text-dark px-4">{{ strtoupper($p->nama) }}</td>
                                    <td class="text-center">{{ $p->nik }}</td>
                                    <td>{{ $p->hp ?? '-' }}</td>

                                    <td class="text-center">
                                        @if ($p->foto)
                                            <button class="btn btn-outline-info btn-sm px-3 shadow-sm"
                                                data-bs-toggle="modal" data-bs-target="#mFoto{{ $p->id }}">
                                                <i class="bi bi-person-bounding-box"></i> Lihat
                                            </button>
                                            <div class="modal fade" id="mFoto{{ $p->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow">
                                                        <div class="modal-header bg-light">
                                                            <h6 class="modal-title fw-bold">Foto Diri: {{ $p->nama }}
                                                            </h6>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center p-4">
                                                            @php $pathF = str_contains($p->foto, 'foto_diri/') ? $p->foto : 'foto_diri/' . $p->foto; @endphp
                                                            <img src="{{ asset('storage/' . $pathF) }}"
                                                                class="img-fluid rounded shadow">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if ($p->foto_ktp)
                                            <button class="btn btn-outline-secondary btn-sm px-3 shadow-sm"
                                                data-bs-toggle="modal" data-bs-target="#mKtp{{ $p->id }}">
                                                <i class="bi bi-card-heading"></i> Lihat
                                            </button>
                                            <div class="modal fade" id="mKtp{{ $p->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow">
                                                        <div class="modal-header bg-light">
                                                            <h6 class="modal-title fw-bold">Foto KTP: {{ $p->nama }}
                                                            </h6>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center p-4">
                                                            @php $pathK = str_contains($p->foto_ktp, 'foto_ktp/') ? $p->foto_ktp : 'foto_ktp/' . $p->foto_ktp; @endphp
                                                            <img src="{{ asset('storage/' . $pathK) }}"
                                                                class="img-fluid rounded shadow">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ $urlWA }}" target="_blank"
                                                class="btn btn-success btn-sm border-0 shadow-sm" title="Hubungi WA">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>
                                            <a href="{{ route('penitip.edit', $p->id) }}"
                                                class="btn btn-warning btn-sm border-0 shadow-sm text-white" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('penitip.destroy', $p->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm border-0 shadow-sm"
                                                    title="Hapus">
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
        #main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .table thead th {
            font-weight: 600;
            font-size: 0.85rem;
            background-color: #212529;
            vertical-align: middle !important;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            vertical-align: middle !important;
            border-bottom: 1px solid #f0f2f5;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .modal-backdrop {
            z-index: 1040 !important;
        }

        .modal {
            z-index: 1050 !important;
        }

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
