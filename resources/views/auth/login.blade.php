<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KAGATAU Rutan Rembang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow: hidden;
        }

        .bg-auth {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.85)), 
                              url('{{ asset("assets/img/bg-rutan.jpg") }}');
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card-auth {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 420px;
            transition: transform 0.3s ease;
        }

        .auth-header img {
            filter: drop-shadow(0 0 15px rgba(255,255,255,0.2));
            margin-bottom: 20px;
        }

        .auth-header h4 {
            color: #ffffff;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.7) !important;
            font-weight: 600;
            font-size: 0.8rem;
            margin-bottom: 8px;
        }

        .input-group {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            border-color: #3498db;
            box-shadow: 0 0 15px rgba(52, 152, 219, 0.2);
        }

        .input-group-text {
            background: transparent !important;
            border: none !important;
            color: rgba(255, 255, 255, 0.5) !important;
            padding-left: 15px;
        }

        .form-control {
            background: transparent !important;
            border: none !important;
            color: white !important;
            padding: 12px 15px 12px 5px;
            font-size: 0.95rem;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }

        .form-control:focus {
            box-shadow: none;
        }

        .btn-auth {
            background: linear-gradient(45deg, #3498db, #2980b9);
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            color: white;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-auth:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(52, 152, 219, 0.4);
            filter: brightness(1.1);
        }

        .auth-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .back-link {
            color: rgba(255, 255, 255, 0.4);
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .back-link:hover {
            color: white;
        }
    </style>
</head>
<body>

    <div class="bg-auth">
        <div class="card card-auth border-0">
            <div class="card-body p-5">
                
                <div class="auth-header text-center mb-5">
                    <img src="{{ asset('assets/img/logo-pemasyarakatan.png') }}" width="75" alt="Logo">
                    <h4 class="mb-1">LOGIN SISTEM</h4>
                    <p class="text-info small fw-bold text-uppercase" style="letter-spacing: 2px;">Aplikasi KAGATAU</p>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger border-0 small py-3 mb-4 rounded-4" style="background: rgba(231, 76, 60, 0.15); color: #ff7675;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success border-0 small py-3 mb-4 rounded-4" style="background: rgba(46, 204, 113, 0.15); color: #2ecc71;">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">USERNAME</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                            <input type="text" name="username" class="form-control" 
                                   placeholder="Masukkan username..." required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">PASSWORD</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
                            <input type="password" name="password" class="form-control" 
                                   placeholder="Masukkan password..." required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-auth w-100 mb-3">
                        MASUK SISTEM <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
                    </button>
                </form>

                <div class="auth-footer text-center">
                    <a href="{{ route('landing') }}" class="back-link">
                        <i class="bi bi-chevron-left small me-1"></i> Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>