<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Farmasi | {{ $title ?? 'Dashboard' }}</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background:rgb(243, 213, 248);
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
            background:rgb(245, 194, 253);
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

        .main-content {
            flex: 1;
            padding: 32px;
            overflow-y: auto;
            /* Agar bisa discroll jika konten panjang */
        }

        /* Style Card Putih untuk konten (Opsional, agar mirip content area Template 1 tapi style Template 2) */
        .content-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Tambahan Utility untuk Table/Button di dalam content */
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary {
            background: #1d4ed8;
            color: white;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: white;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f8f9fa;
            font-weight: 600;
        }
    </style>

    @yield('css')
</head>

<body>

    <div class="wrapper">
        {{-- SIDEBAR --}}
        <aside class="sidebar">
            <h1>🏥 Farmasi</h1>

            <div class="nav">
                {{-- Stok Farmasi --}}
                <a href="{{ route('dashboard-farmasi') }}"
                    class="{{ request()->routeIs('dashboard-farmasi') ? 'active' : '' }}">
                    📦 Stok Farmasi
                </a>

                {{-- Data Obat (resource obat) --}}
                <a href="{{ route('obat.index') }}" class="{{ request()->routeIs('obat.*') ? 'active' : '' }}">
                    💊 Data Obat
                </a>

                {{-- Validasi Resep --}}
                <a href="{{ route('farmasi.validasi.index') }}"
                    class="{{ request()->routeIs('farmasi.validasi.*') ? 'active' : '' }}">
                    ✅ Validasi Resep
                </a>

                {{-- Form Logout --}}
                <form action="/logout" method="POST" style="margin-top: auto;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="logout" onclick="return confirm('Yakin ingin keluar?')">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="main-content">
            {{-- Kita bungkus konten dalam card agar rapi seperti layout dashboard modern --}}
            <div class="content-card">
                @yield('content')
            </div>
        </main>
    </div>

    @yield('js')
</body>

</html>