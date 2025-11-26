<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Gudang & Supplier')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem Manajemen Gudang dan Supplier Rumah Sakit">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-green-50 to-blue-50 text-slate-800 font-sans">

    <nav class="bg-white/90 backdrop-blur-md border-b border-green-200/50 shadow-lg sticky top-0 z-50">
        <div class="w-full mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-green-600 to-green-700 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path>
                            <path fill-rule="evenodd"
                                d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-xl text-slate-800">RS Gudang</h1>
                        <p class="text-xs text-slate-500">Sistem Manajemen Gudang & Supplier</p>
                    </div>
                </div>

                <div class="flex items-center space-x-6">
                    <!-- Navigation Menu -->
                    <nav class="flex gap-2">
                        <a href="{{ route('dashboard.gudang.index') }}"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard.gudang.index') ? 'bg-green-100 text-green-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                            📊 Dashboard
                        </a>
                        <a href="{{ route('dashboard.gudang.obat.index') }}"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard.gudang.obat.*') ? 'bg-green-100 text-green-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                            💊 Obat
                        </a>
                        <a href="{{ route('dashboard.gudang.requests.index') }}"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard.gudang.requests.*') ? 'bg-green-100 text-green-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                            📋 Requests
                        </a>
                        <a href="{{ route('dashboard.suppliers.index') }}"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard.suppliers.*') ? 'bg-green-100 text-green-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                            🏢 Supplier
                        </a>
                    </nav>

                    <!-- User Info & Logout -->
                    <div class="flex items-center space-x-3 border-l border-slate-200 pl-6">
                        <div class="text-right hidden md:block">
                            <div class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-slate-500">
                                {{ ucfirst(str_replace('_', ' ', strtolower(Auth::user()->role))) }}
                            </div>
                        </div>

                        <form method="POST" action="{{ route('logout') }}" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin logout?')"
                                class="flex items-center px-4 py-2 text-sm font-bold text-red-700 bg-red-50 hover:bg-red-100 hover:text-red-800 rounded-lg border-2 border-red-200 hover:border-red-300 shadow-md transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-red-100"
                                title="Logout dari sistem">
                                <svg class="w-4 h-4 mr-2 text-red-600" fill="currentColor" stroke="none"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6z"
                                        clip-rule="evenodd" />
                                    <path fill-rule="evenodd"
                                        d="M19.5 12a.75.75 0 000-1.5H9.75a.75.75 0 000 1.5h9.75zM14.47 15.53a.75.75 0 001.06-1.06L13.06 12l2.47-2.47a.75.75 0 00-1.06-1.06l-3 3a.75.75 0 000 1.06l3 3z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-bold">LOGOUT</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-6 min-h-[calc(100vh-120px)]">
        @if(session('ok'))
            <div
                class="mb-6 p-4 bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 rounded-xl border border-green-200 shadow-sm flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">{{ session('ok') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div
                class="mb-6 p-4 bg-gradient-to-r from-red-100 to-rose-100 text-red-800 rounded-xl border border-red-200 shadow-sm">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div
                class="mb-6 p-4 bg-gradient-to-r from-red-100 to-rose-100 text-red-800 rounded-xl border border-red-200 shadow-sm">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">Terdapat kesalahan:</span>
                </div>
                <ul class="list-disc list-inside text-sm space-y-1 ml-8">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    @yield('js')
</body>

</html>