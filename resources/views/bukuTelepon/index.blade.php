@extends('layouts.main')

@section('title', 'Buku Telepon')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Buku Telepon</h4>
                <p class="text-muted small mb-0">Gabungan data layanan dari database Sipirman & Kagatau</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-5 col-lg-4">
                <form action="{{ route('bukutelepon.index') }}" method="GET">
                    <div class="input-group shadow-sm">
                        <input type="text" name="search" class="form-control border-secondary-subtle"
                            placeholder="Cari Tahanan atau No. HP..." value="{{ request('search') }}">
                        <button class="btn btn-dark px-3" type="submit" style="background-color: #0a2d5a; border: none;">
                            <i class="bi bi-search"></i>
                        </button>
                        @if (request('search'))
                            <a href="{{ route('bukutelepon.index') }}" class="btn btn-outline-danger" title="Reset">
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
                        <thead class="text-nowrap" style="background-color: color: white;">
                            <tr>
                                <th width="60" class="text-center py-3 border-0">No</th>
                                <th class="py-3 border-0 px-4">Nama Tahanan</th>
                                <th class="py-3 border-0">Keluarga</th>
                                <th class="py-3 border-0 text-center">No. HP</th>
                                <th class="py-3 border-0 text-center">Hubungan</th>
                                <th width="150" class="text-center py-3 border-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bukuTelepon as $item)
                                <tr>
                                    <td class="text-center text-muted small">{{ $loop->iteration }}</td>
                                    <td class="fw-semibold text-dark px-4">{{ strtoupper($item->nama_tahanan) }}</td>
                                    <td>{{ $item->nama_keluarga }}</td>
                                    <td class="text-center">{{ $item->nomor_hp ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">
                                            {{ $item->hubungan ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2">

                                            @php
                                                // 1. Bersihkan semua karakter non-angka (spasi, strip, dsb)
                                                $cleanNumber = preg_replace('/[^0-9]/', '', $item->nomor_hp);

                                                // 2. Cek validasi dasar
                                                $isValid = $cleanNumber && $cleanNumber != '0';

                                                if ($isValid) {
                                                    // 3. JIKA NOMOR DIMULAI DENGAN '0', UBAH JADI '62'
                                                    if (str_starts_with($cleanNumber, '0')) {
                                                        $cleanNumber = '62' . substr($cleanNumber, 1);
                                                    }
                                                    // 4. Jika nomor dimulai dengan '8' (tanpa 0), langsung tambahkan '62'
                                                    elseif (str_starts_with($cleanNumber, '8')) {
                                                        $cleanNumber = '62' . $cleanNumber;
                                                    }
                                                }
                                            @endphp

                                            {{-- Tombol WhatsApp --}}
                                            @if ($isValid)
                                                <a href="https://api.whatsapp.com/send?phone={{ $cleanNumber }}"
                                                    target="_blank"
                                                    class="btn btn-success btn-sm d-flex align-items-center justify-content-center"
                                                    style="width: 32px; height: 32px;">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>
                                            @else
                                                {{-- Tampilan jika nomor tidak ada atau cuma angka 0 --}}
                                                <button class="btn btn-secondary btn-sm opacity-50"
                                                    style="width: 32px; height: 32px;" disabled>
                                                    <i class="bi bi-whatsapp"></i>
                                                </button>
                                            @endif

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('bukuTelepon.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus nomor ini?')" class="m-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm border-0 shadow-sm"
                                                    style="width: 32px; height: 32px;">
                                                    <i class="bi bi-trash">></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
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
            vertical-align: middle !important;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            vertical-align: middle !important;
            border-bottom: 1px solid #f0f2f5;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(10, 45, 90, 0.05);
        }

        .badge {
            font-weight: 500;
        }
    </style>
@endsection
