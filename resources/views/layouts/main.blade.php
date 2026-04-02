<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAGATAU - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: #f4f6f9; }
        #sidebar { width: 280px; height: 100vh; position: fixed; background: #2c3e50; color: white; }
        #main-content { margin-left: 280px; padding: 20px; }
        .nav-link { color: #bdc3c7; margin-bottom: 5px; }
        .nav-link.active { background: #3498db; color: white; border-radius: 5px; }
        .nav-link:hover { color: white; }
        .logo-text { padding: 20px; border-bottom: 1px solid #3e4f5f; }
    </style>
</head>
<body>

<div id="sidebar" class="d-flex flex-column p-3">
    <div class="logo-text">
        <h4 class="mb-0">KAGATAU</h4>
        <small class="text-info" style="font-size: 10px;">LAYANAN KABARI KELUARGA TAHANAN BARU</small>
    </div>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li><a href="/" class="nav-link {{ Request::is('/') ? 'active' : '' }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
        <li><a href="#" class="nav-link"><i class="bi bi-briefcase me-2"></i> Data Layanan</a></li>
        <li><a href="/tahanan" class="nav-link {{ Request::is('tahanan*') ? 'active' : '' }}"><i class="bi bi-people me-2"></i> Data Tahanan</a></li>
        <li><a href="#" class="nav-link"><i class="bi bi-person-hearts me-2"></i> Data Keluarga</a></li>
        <li><a href="#" class="nav-link"><i class="bi bi-telephone me-2"></i> Buku Telepon</a></li>
    </ul>
</div>

<div id="main-content">
    @yield('content')
</div>

</body>
</html>