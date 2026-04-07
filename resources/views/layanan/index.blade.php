@extends('layouts.main')
@section('title', 'Data Layanan')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Daftar Antrean Layanan</h4>
                <p class="text-muted small mb-0">Manajemen data layanan KAGATAU - Database: Kagatau</p>
            </div>
            <a href="{{ route('layanan.create') }}" class="btn btn-primary shadow-sm px-3">
                <i class="bi bi-plus-lg me-1"></i> Tambah Layanan Baru
            </a>
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
                                <th class="text-center py-3">Nama Tahanan</th>
                                <th class="text-center py-3">Nama Keluarga</th>
                                <th class="text-center py-3">Hubungan</th>
                                <th class="text-center py-3">No. HP</th>
                                <th class="text-center py-3">Screenshot</th>
                                <th class="text-center py-3">Dokumentasi</th>
                                <th class="text-center py-3">Status</th> <th class="text-center py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($layanans as $l)
                                @php
                                    $jsonPath = storage_path('app/wa_settings.json');
                                    $waSettings = file_exists($jsonPath)
                                        ? json_decode(file_get_contents($jsonPath), true)
                                        : [];
                                    $rawMessage = $waSettings['wa_template'] ?? 'Halo [nama_keluarga]...';
                                    
                                    // Pembersihan Nama (Menghilangkan [""])
                                    $namaK = str_replace(['[', ']', '"'], '', (string) ($l->keluarga->nama ?? 'N/A'));
                                    $namaT = str_replace(['[', ']', '"'], '', (string) ($l->keluarga->nama_wbp ?? 'N/A'));

                                    $pesanFinal = str_replace(
                                        ['[nama_keluarga]', '[nama_tahanan]'],
                                        [strtoupper($namaK), strtoupper($namaT)],
                                        $rawMessage,
                                    );

                                    $nomorTarget = $l->hp_manual ?? ($l->keluarga->hp ?? '');
                                    $nomorWA = preg_replace('/[^0-9]/', '', $nomorTarget);
                                    if (str_starts_with($nomorWA, '0')) {
                                        $nomorWA = '62' . substr($nomorWA, 1);
                                    }
                                    $urlWA = 'https://api.whatsapp.com/send?phone=' . $nomorWA . '&text=' . urlencode($pesanFinal);
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="small">{{ $l->tanggal_masuk }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($l->tanggal_layanan)->format('d/m/Y') }}
                                    </td>
                                    <td class="fw-bold">{{ strtoupper($namaT) }}</td>
                                    <td>{{ strtoupper($namaK) }}</td>
                                    <td class="text-center small">{{ $l->hubungan ?? '-' }}</td>
                                    <td class="text-center">{{ $nomorTarget }}</td>

                                    <td class="text-center">
                                        @if ($l->screenshot)
                                            <a href="{{ asset('storage/' . $l->screenshot) }}" target="_blank"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-image"></i> Lihat
                                            </a>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle small">Belum</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if ($l->dokumentasi)
                                            <a href="{{ asset('storage/' . $l->dokumentasi) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-camera"></i> Lihat
                                            </a>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle small">Belum</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if ($l->status == 'pending')
                                            <span class="badge bg-warning text-dark px-2 py-1">
                                                <i class="bi bi-clock"></i> PENDING
                                            </span>
                                        @else
                                            <span class="badge bg-success px-2 py-1">
                                                <i class="bi bi-check-circle"></i> TERLAYANI
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ $urlWA }}" target="_blank"
                                                onclick="setTimeout(function(){ window.location.href='{{ route('layanan.layani', $l->id) }}'; }, 500);"
                                                class="btn btn-success btn-sm shadow-sm" title="Layani">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>
                                            
                                            <a href="{{ route('layanan.edit', $l->id) }}" 
                                                class= "btn btn-warning btn-sm text-white border-0 shadow-sm" title="Update">
                                        <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form action="{{ route('layanan.destroy', $l->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus data layanan ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-5 text-muted">Belum ada data layanan di database Kagatau.</td>
                                </tr>
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