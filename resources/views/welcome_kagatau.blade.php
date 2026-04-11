<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAGATAU - Rutan Rembang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        .bg-landing {
            background-image: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.85)), 
                              url('{{ asset("assets/img/bg-rutan.jpg") }}');
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        @keyframes float {
            0% { transform: translateY(0px); filter: drop-shadow(0 5px 15px rgba(255,255,255,0.2)); }
            50% { transform: translateY(-15px); filter: drop-shadow(0 20px 30px rgba(52, 152, 219, 0.4)); }
            100% { transform: translateY(0px); filter: drop-shadow(0 5px 15px rgba(255,255,255,0.2)); }
        }

        .title-area {
            max-width: 950px;
            margin: 0 auto;
            color: white;
            z-index: 5;
        }

        .main-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 4.5rem;
            letter-spacing: 10px;
            margin-bottom: 0px;
            background: linear-gradient(to bottom, #ffffff, #bdc3c7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        .sub-title {
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 4px;
            color: #3498db;
            text-transform: uppercase;
            margin-bottom: 25px;
        }

        .description {
            font-size: 1.05rem;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 40px;
            padding: 0 50px;
            font-weight: 400;
            border-left: 3px solid #3498db;
            border-right: 3px solid #3498db;
        }

        .description b {
            color: #3498db;
            font-weight: 600;
        }

        .logo-container {
            margin-top: 10px;
            margin-bottom: 25px;
        }

        .logo-btn {
            width: 170px;
            animation: float 4s ease-in-out infinite;
            transition: all 0.4s ease;
            cursor: pointer;
        }

        .logo-btn:hover {
            transform: scale(1.1);
            filter: drop-shadow(0 0 30px rgba(52, 152, 219, 0.6));
        }

        .hint-text {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: #7f8c8d;
            font-weight: 600;
            transition: 0.3s;
        }

        .logo-container:hover + .hint-area .hint-text {
            color: #ffffff;
            letter-spacing: 6px;
        }
    </style>
</head>
<body>

    <div class="bg-landing">
        <div class="container" style="position: relative; z-index: 2;">
            
            <div class="title-area">
                <h1 class="main-title">KAGATAU</h1>
                <p class="sub-title">Rutan Kelas IIB Rembang</p>
                
                <p class="description">
                    Merupakan <b>inovasi layanan</b> yang bertujuan untuk memberikan informasi kepada keluarga terkait keberadaan anggota keluarganya yang baru saja masuk sebagai <b>Tahanan atau Narapidana</b> di Rutan Kelas IIB Rembang. Sebagai perwujudan layanan informasi <b>jemput bola</b>, layanan ini memberikan informasi terkait prosedur-prosedur pelayanan, kontak resmi Rutan Rembang, serta himbauan penipuan dan calo layanan, sebagai sarana pencegahan <b>miss-informasi</b> sejak dini.
                </p>
            </div>

            <div class="logo-container">
                <a href="{{ route('login') }}">
                    <img src="{{ asset('assets/img/logo-pemasyarakatan.png') }}" alt="Logo" class="logo-btn">
                </a>
            </div>

            <div class="hint-area">
                <span class="hint-text">KETUK LOGO UNTUK MASUK</span>
            </div>
            
        </div>
    </div>

</body>
</html>