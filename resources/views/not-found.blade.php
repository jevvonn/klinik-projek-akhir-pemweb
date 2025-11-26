<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 Halaman Tidak Ditemukan - Sistem Klinik</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #a2d3e0 0%, #7ab8cc 100%);
            height: 100vh;
            /* Mengunci tinggi pas 100% layar */
            overflow: hidden;
            /* Mencegah scrollbar */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .not-found-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 500px;
            /* Sedikit lebih lebar dari login agar ilustrasi muat */
            padding: 40px;
            text-align: center;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Styling untuk Ilustrasi SVG */
        .illustration-404 {
            width: 100%;
            max-width: 350px;
            height: auto;
            margin-bottom: 30px;
        }

        /* Mengatur warna elemen SVG agar sesuai tema */
        .svg-primary {
            fill: #7ab8cc;
        }

        .svg-secondary {
            fill: #a2d3e0;
        }

        .svg-accent {
            fill: #e0e0e0;
        }

        .svg-dark {
            fill: #4a5568;
        }

        .not-found-content h1 {
            font-size: 48px;
            font-weight: 700;
            color: #7ab8cc;
            /* Menggunakan warna tema yang lebih gelap */
            margin-bottom: 10px;
            line-height: 1;
        }

        .not-found-content h2 {
            font-size: 22px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        .not-found-content p {
            color: #666;
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 30px;
        }

        /* Menggunakan style button yang sama dengan login */
        .back-button {
            display: inline-block;
            width: auto;
            min-width: 200px;
            padding: 15px 30px;
            background: linear-gradient(135deg, #a2d3e0 0%, #7ab8cc 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            /* Karena ini tag <a> */
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(162, 211, 224, 0.3);
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(162, 211, 224, 0.5);
        }

        .back-button:active {
            transform: translateY(0);
        }

        @media (max-width: 480px) {
            .not-found-container {
                padding: 30px 20px;
            }

            .not-found-content h1 {
                font-size: 36px;
            }

            .not-found-content h2 {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="not-found-container">
        <svg class="illustration-404" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 400">
            <g transform="translate(50, 50)">
                <rect class="svg-accent" x="20" y="80" width="60" height="80" rx="5"
                    transform="rotate(-15)" />
                <rect class="svg-secondary" x="300" y="50" width="70" height="90" rx="5"
                    transform="rotate(10)" />

                <text class="svg-accent" x="200" y="250" font-size="180" font-weight="900" text-anchor="middle"
                    opacity="0.2">404</text>

                <g transform="translate(120, 60)">
                    <path class="svg-secondary" d="M60,180 C30,180 20,260 20,280 L100,280 C100,260 90,180 60,180 Z" />
                    <circle class="svg-primary" cx="60" cy="130" r="35" />
                    <circle fill="white" cx="50" cy="125" r="5" />
                    <circle fill="white" cx="70" cy="125" r="5" />
                    <path class="svg-dark" d="M55,145 Q60,140 65,145" fill="none" stroke-width="2"
                        stroke-linecap="round" />
                    <path class="svg-dark" d="M60,165 C30,165 30,220 40,230" fill="none" stroke-width="3"
                        stroke-linecap="round" />
                    <circle class="svg-dark" cx="40" cy="230" r="7" />
                    <g transform="translate(80, 140) rotate(-20)">
                        <circle class="svg-accent" cx="0" cy="0" r="30" stroke="#7ab8cc"
                            stroke-width="5" fill="rgba(255,255,255,0.5)" />
                        <rect class="svg-dark" x="-5" y="30" width="10" height="40" rx="5" />
                    </g>
                    <text class="svg-primary" x="0" y="100" font-size="40" font-weight="bold">?</text>
                    <text class="svg-secondary" x="110" y="90" font-size="30" font-weight="bold">?</text>
                </g>
            </g>
        </svg>

        <div class="not-found-content">
            <h1>404</h1>
            <h2>Ups! Halaman Medis Tidak Ditemukan</h2>
            <p>Sepertinya halaman yang Anda cari sedang dalam penanganan atau telah dipindahkan ke ruangan lain. Mari
                kembali
                ke lobi utama.</p>

            <a href="/" class="back-button">Kembali ke Beranda</a>
        </div>
    </div>
</body>

</html>
