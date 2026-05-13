<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAGATAU - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }

        #sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            background: #1a252f;
            color: white;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        #main-content {
            margin-left: 280px;
            padding: 30px;
        }

        .logo-text {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(0, 0, 0, 0.1);
        }

        .logo-text h4 {
            letter-spacing: 2px;
            font-weight: 700;
            color: #fff;
        }

        .nav-pills {
            padding: 15px;
        }

        .nav-link {
            color: #aeb9c1;
            margin-bottom: 8px;
            padding: 12px 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: linear-gradient(45deg, #3498db, #2980b9) !important;
            color: white !important;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .nav-link i {
            font-size: 1.1rem;
        }

        .nav-link-logout:hover {
            background: rgba(231, 76, 60, 0.2) !important;
            color: #e74c3c !important;
        }

        .sidebar-heading {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.3);
            padding: 10px 20px 5px;
            font-weight: 700;
        }

        #sidebar::-webkit-scrollbar { width: 5px; }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); }
    </style>
</head>

<body>

    <div id="sidebar" class="d-flex flex-column">
        <div class="logo-text text-center">
            <h4 class="mb-0">KAGATAU</h4>
            <small class="text-info fw-bold" style="font-size: 9px; opacity: 0.8;">RUTAN REMBANG</small>
        </div>

        <div class="p-2">
            <ul class="nav nav-pills flex-column mb-auto">
                <div class="sidebar-heading">Menu Utama</div>
                <li>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill me-3"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/layanan" class="nav-link {{ Request::is('layanan*') ? 'active' : '' }}">
                        <i class="bi bi-briefcase-fill me-3"></i> Data Layanan
                    </a>
                </li>
                <li>
                    <a href="/tahanan" class="nav-link {{ Request::is('tahanan*') ? 'active' : '' }}">
                        <i class="bi bi-shield-lock-fill me-3"></i> Data Tahanan
                    </a>
                </li>
                <li>
    <a href="{{ route('pin-saku.index') }}" class="nav-link {{ Request::is('pin-saku*') ? 'active' : '' }}">
        <i class="bi bi-key-fill me-3"></i> PIN Saku WBP
    </a>
</li>
                <li>
                    <a href="/penitip" class="nav-link {{ Request::is('penitip*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill me-3"></i> Data Keluarga
                    </a>
                </li>
                <li>
                    <a href="/buku-telepon" class="nav-link {{ Request::is('buku-telepon*') ? 'active' : '' }}">
                        <i class="bi bi-telephone-fill me-3"></i> Buku Telepon
                    </a>
                </li>

                {{-- Khusus Admin --}}
                @if(Auth::user()->role === 'admin')
                <div class="sidebar-heading mt-3">Administrasi</div>
                <li>
                    <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users') ? 'active' : '' }}">
                        <i class="bi bi-people-gear-fill me-3"></i> Manajemen Petugas
                    </a>
                </li>
                @endif

                <div class="sidebar-heading mt-3">Pengaturan</div>
                <li>
                    <a href="/setting" class="nav-link {{ Request::is('setting*') ? 'active' : '' }}">
                        <i class="bi bi-gear-wide-connected me-3"></i> Setting WA
                    </a>
                </li>

                <li>
                    <a href="{{ route('users.edit', Auth::id()) }}" class="nav-link {{ Request::is('users/*/edit') ? 'active' : '' }}">
                        <i class="bi bi-person-circle me-3"></i> Profil Saya
                    </a>
                </li>

                <hr style="border-color: rgba(255,255,255,0.1)">

                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button type="submit" class="nav-link nav-link-logout border-0" style="background:none;">
                            <i class="bi bi-box-arrow-right me-3"></i> Keluar Sistem
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="mt-auto p-4 text-center">
            <div class="badge bg-dark text-muted p-2 w-100" style="font-size: 10px; font-weight: 400;">
                v2.0 Beta - 2026
            </div>
        </div>
    </div>

    <div id="main-content">
        <div class="container-fluid">
            {{-- Alert Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>