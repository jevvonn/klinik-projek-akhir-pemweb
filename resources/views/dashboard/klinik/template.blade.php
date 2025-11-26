<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Klinik | {{ $title }}</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: #d0e7f1;
        }

        .wrapper {
            display: flex;
        }

        .sidebar {
            width: 230px;
            height: 100vh;
            background: white;
            border-right: 1px solid #ddd;
            padding: 32px 20px;
            display: flex;
            flex-direction: column;
        }

        .nav a.active {
            background: #a2d3e0;
            color: white;
            font-weight: 600;
        }


        .sidebar h1 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .nav a,
        .nav .logout {
            text-decoration: none;
            font-size: 16px;
            padding: 12px 14px;
            border-radius: 10px;
            color: #444;
            transition: 0.25s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav a:hover,
        .nav .logout:hover {
            background: #f0f5ff;
            color: #000;
        }

        .logout {
            margin-top: auto;
            width: 100%;
            color: #c0392b;
            background: transparent;
            cursor: pointer;
            border: none;
        }
    </style>
    @yield('css')

</head>

<body>
    <div class="wrapper">
        <aside class="sidebar">
            <h1>🏥 Klinik</h1>

            <div class="nav">
                <a href="/dashboard/klinik" class="{{ request()->is('dashboard/klinik') ? 'active' : '' }}">
                    📊 Beranda
                </a>

                <a href="/dashboard/klinik/tambah-pasien"
                    class="{{ request()->is('dashboard/klinik/tambah-pasien') ? 'active' : '' }}">
                    👤 Form Input Pasien
                </a>

                <form action="/logout" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="logout" onclick="return confirm('Yakin ingin keluar?')">
                        🚪 Logout
                    </button>
                </form>

            </div>
        </aside>

        @yield('content')

        @yield('js')
</body>

</html>
