@extends('layouts.main')
@section('title', 'Tambah Layanan')

@section('content')
    <div class="container-fluid px-4">
        <div class="mt-4 mb-3">
            <h4 class="fw-bold text-dark"><i class="bi bi-plus-circle-fill me-2 text-primary"></i>Input Data Layanan Baru</h4>
            <p class="text-muted small">Hubungkan data Tahanan dan data Keluarga untuk mendaftarkan antrean.</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                {{-- Alert Success/Error --}}
                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-3">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <form action="{{ route('layanan.store') }}" method="POST" autocomplete="off">
                            @csrf

                            <div class="row">
                                {{-- Dropdown Pilih Tahanan --}}
                                <div class="col-md-12 mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label fw-bold text-secondary small text-uppercase mb-0">1. Pilih Tahanan (WBP)</label>
                                        <button type="button" class="btn btn-sm btn-primary py-0 px-2"
                                            data-bs-toggle="modal" data-bs-target="#modalTambahTahanan">
                                            <i class="bi bi-plus-lg"></i> Tahanan Baru
                                        </button>
                                    </div>
                                    <select name="tahanan_id" id="tahanan_select" class="form-select select2" required>
                                        <option value="">-- Cari Nama Tahanan --</option>
                                        @foreach ($tahanans as $t)
                                            <option value="{{ $t->id }}">
                                                {{ strtoupper($t->nama) }} — [{{ $t->code_napi }}]
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Dropdown Pilih Keluarga --}}
                                <div class="col-md-12 mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label fw-bold text-secondary small text-uppercase mb-0">2. Pilih Keluarga (Pengunjung)</label>
                                        <button type="button" class="btn btn-sm btn-primary py-0 px-2"
                                            data-bs-toggle="modal" data-bs-target="#modalTambahKeluarga">
                                            <i class="bi bi-plus-lg"></i> Keluarga Baru
                                        </button>
                                    </div>
                                    <select name="penitip_id" id="penitip_select" class="form-select select2" required>
                                        <option value="">-- Cari Nama Keluarga --</option>
                                        @foreach ($keluargas as $k)
                                            <option value="{{ $k->id }}">
                                                {{ strtoupper($k->nama) }} — [NIK: {{ $k->nik ?? '-' }}]
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- No. HP & Hubungan --}}
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold text-secondary small text-uppercase">No. HP Baru (Opsional)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-whatsapp"></i></span>
                                        <input type="text" name="hp_manual" class="form-control" placeholder="Isi jika ganti nomor">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold text-secondary small text-uppercase">Hubungan Keluarga</label>
                                    <select name="hubungan" class="form-select" required>
                                        <option value="">-- Pilih Hubungan --</option>
                                        @foreach(['AYAH', 'IBU', 'ISTRI', 'SUAMI', 'ANAK', 'KAKAK', 'ADIK', 'LAINNYA'] as $hub)
                                            <option value="{{ $hub }}">{{ $hub }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('layanan.index') }}" class="btn btn-light px-4 border shadow-sm">
                                    <i class="bi bi-arrow-left me-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-5 shadow-sm fw-bold">
                                    <i class="bi bi-save me-1"></i> Simpan Antrean
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Sidebar Info --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-primary text-white mb-3" style="border-radius: 12px;">
                    <div class="card-body">
                        <h6 class="fw-bold"><i class="bi bi-shuffle me-2"></i>Integrasi Database</h6>
                        <hr class="bg-white">
                        <ul class="small mb-0 ps-3">
                            <li class="mb-2">Gunakan tombol biru di atas dropdown jika data belum terdaftar.</li>
                            <li class="mb-2">Data <strong>Tahanan</strong> masuk ke DB <strong>Sipirman</strong>.</li>
                            <li class="mb-2">Data <strong>Keluarga</strong> masuk ke DB <strong>Sipirman</strong> (Tabel Penitip).</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH TAHANAN (DIUBAH KE AUTO GENERATE CODE) --}}
    <div class="modal fade" id="modalTambahTahanan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title small fw-bold text-uppercase"><i class="bi bi-person-plus-fill me-2"></i>Tambah Tahanan Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tahanan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Code NAPI / Tahanan</label>
                            {{-- MODIFIKASI: Jadi Readonly karena di-generate di Controller --}}
                            <input type="text" class="form-control bg-light fw-bold text-primary" 
                                   value="OTOMATIS (8 DIGIT UNIK)" readonly>
                            <div class="form-text small text-info">Sistem akan membuatkan kode unik setelah disimpan.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Nama Lengkap Tahanan</label>
                            <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama sesuai berkas">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" class="form-control" required value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control" required placeholder="Nama ayah">
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm">SIMPAN TAHANAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH KELUARGA --}}
    <div class="modal fade" id="modalTambahKeluarga" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title small fw-bold text-uppercase"><i class="bi bi-person-vcard-fill me-2"></i>Registrasi Keluarga Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('penitip.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control" required placeholder="Nama sesuai KTP">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">NIK <span class="text-muted italic small">(opsional)</span></label>
                                <input type="number" name="nik" class="form-control" placeholder="Kosongkan jika tidak ada" oninput="if (this.value.length > 16) this.value = this.value.slice(0, 16);">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">No. HP (WA) <span class="text-danger">*</span></label>
                                <input type="number" name="hp" class="form-control" required placeholder="0812..." oninput="if (this.value.length > 13) this.value = this.value.slice(0, 13);">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Foto Diri <span class="text-muted italic small">(opsional)</span></label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Foto KTP <span class="text-muted italic small">(opsional)</span></label>
                                <input type="file" name="foto_ktp" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm">SIMPAN KELUARGA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Assets --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tahanan_select, #penitip_select').select2({
                theme: 'bootstrap-5',
                allowClear: true,
                width: '100%'
            });
        });
    </script>

    <style>
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: 8px;
            min-height: 45px;
            padding-top: 5px;
            border: 1px solid #dee2e6;
        }
        .input-group-text { border-radius: 8px 0 0 8px; }
        .form-control, .form-select { border-radius: 8px; }
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .italic { font-style: italic; }
    </style>
@endsection