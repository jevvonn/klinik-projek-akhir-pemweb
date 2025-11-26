@extends('dashboard.gudang.template')
@section('title', 'Dashboard Gudang')

@section('content')
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 mb-2">Dashboard Gudang</h1>
                    <p class="text-slate-600">Kelola stok obat dan request dari farmasi</p>
                </div>
            </div>

            <!-- Priority Alerts & Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Left Column: Critical Alerts -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-slate-800">🚨 Perhatian Khusus</h2>

                    <!-- Request Pending Alert -->
                    @if($requestsPending > 0)
                        <a href="{{ route('dashboard.gudang.requests.index') }}" class="block">
                            <div
                                class="bg-gradient-to-r from-orange-50 to-red-50 border border-orange-200 rounded-xl p-4 hover:shadow-md transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-800">{{ $requestsPending }} Request Menunggu</p>
                                            <p class="text-sm text-orange-600">Perlu persetujuan segera</p>
                                        </div>
                                    </div>
                                    <div class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-medium">
                                        Action Required
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif

                    <!-- Stok Gudang Rendah -->
                    @if($stokRendah > 0)
                        <a href="{{ route('dashboard.gudang.obat.index') }}?filter=low_stock" class="block">
                            <div
                                class="bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-xl p-4 hover:shadow-md transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-800">{{ $stokRendah }} Obat Stok Rendah</p>
                                            <p class="text-sm text-red-600">Stok gudang < 10 unit</p>
                                        </div>
                                    </div>
                                    <div class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                                        Restock Needed
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif

                    <!-- Stok Farmasi Rendah -->
                    @if($stokFarmasiRendah > 0)
                        <a href="{{ route('dashboard.gudang.requests.index') }}?filter=auto_system" class="block">
                            <div
                                class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-xl p-4 hover:shadow-md transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-800">{{ $stokFarmasiRendah }} Obat Perlu Distribusi</p>
                                            <p class="text-sm text-yellow-600">Stok farmasi di bawah minimum</p>
                                        </div>
                                    </div>
                                    <div class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium">
                                        Distribute
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif

                    @if($requestsPending == 0 && $stokRendah == 0 && $stokFarmasiRendah == 0)
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800">Semua dalam Kondisi Baik</p>
                                    <p class="text-sm text-green-600">Tidak ada alert yang memerlukan tindakan</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Quick Actions -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-slate-800">⚡ Aksi Cepat</h2>

                    <div class="space-y-3">
                        <a href="{{ route('dashboard.gudang.requests.index') }}"
                            class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200 hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                        <path fill-rule="evenodd"
                                            d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 2a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800">Kelola Request</p>
                                    <p class="text-sm text-slate-600">Proses permintaan farmasi</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>

                        <a href="{{ route('dashboard.gudang.obat.index') }}"
                            class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200 hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800">Kelola Stok Obat</p>
                                    <p class="text-sm text-slate-600">{{ $totalObat }} obat terdaftar</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>

                        <a href="{{ route('dashboard.suppliers.index') }}"
                            class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200 hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800">Kelola Supplier</p>
                                    <p class="text-sm text-slate-600">Manage data supplier</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>

                        <a href="{{ route('dashboard.gudang.obat.create') }}"
                            class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200 hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800">Tambah Obat Baru</p>
                                    <p class="text-sm text-slate-600">Daftarkan obat baru</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Receive Section -->
            @if($obat->count() > 0)
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-6">
                    <div
                        class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-green-50 border-b border-emerald-200 flex justify-between items-center">
                        <h3 class="font-semibold text-slate-800">📦 Penerimaan Barang Cepat</h3>
                        <span class="text-xs text-emerald-600 font-medium">Terima barang dari supplier</span>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($obat->take(3) as $o)
                                <div class="bg-slate-50 rounded-lg p-4 hover:bg-slate-100 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                                <span class="text-white font-bold text-xs">{{ substr($o->kode_obat, 0, 2) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-slate-800 text-sm">{{ $o->nama_obat }}</p>
                                                <p class="text-xs text-slate-500">Stok: {{ $o->stok_gudang }}</p>
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="px-3 py-1.5 text-xs font-medium text-green-700 bg-green-100 rounded-lg hover:bg-green-200 transition-colors"
                                            onclick="openReceiveModal({{ $o->id }}, '{{ $o->nama_obat }}')">
                                            ⬆️ Terima
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            @if($obat->count() > 3)
                                <div
                                    class="bg-slate-50 rounded-lg p-4 flex items-center justify-center border-2 border-dashed border-slate-300">
                                    <div class="text-center">
                                        <p class="text-sm text-slate-600 font-medium mb-2">+{{ $obat->count() - 3 }} obat lainnya</p>
                                        <a href="{{ route('dashboard.gudang.obat.index') }}"
                                            class="inline-flex items-center text-xs text-blue-600 hover:text-blue-700 font-medium">
                                            Lihat Semua
                                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Summary Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Stok Perlu Perhatian -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
                        <h3 class="font-semibold text-slate-800">🔥 Stok Perlu Perhatian</h3>
                        <a href="{{ route('dashboard.gudang.obat.index') }}"
                            class="text-xs text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</a>
                    </div>
                    <div class="p-6">
                        @php
    $kriticalObat = collect();
    foreach ($obat as $o) {
        $stokFarmasi = $o->stokFarmasi ? $o->stokFarmasi->jumlah : 0;
        $stokMin = $o->stokFarmasi ? $o->stokFarmasi->stok_minimum : 5;
        if ($o->stok_gudang < 10 || ($o->stokFarmasi && $stokFarmasi <= $stokMin)) {
            $kriticalObat->push($o);
        }
    }
    $kriticalObat = $kriticalObat->take(5);
                        @endphp

                        @if($kriticalObat->count() > 0)
                            <div class="space-y-3">
                                @foreach($kriticalObat as $o)
                                    @php
            $stokFarmasi = $o->stokFarmasi ? $o->stokFarmasi->jumlah : 0;
            $stokMin = $o->stokFarmasi ? $o->stokFarmasi->stok_minimum : 5;
            $isGudangLow = $o->stok_gudang < 10;
            $isFarmasiLow = $o->stokFarmasi && $stokFarmasi <= $stokMin;
                                    @endphp
                                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                                <span class="text-white font-bold text-xs">{{ substr($o->kode_obat, 0, 2) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-slate-800 text-sm">{{ $o->nama_obat }}</p>
                                                <p class="text-xs text-slate-500">{{ $o->kode_obat }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            @if($isGudangLow)
                                                <span class="inline-block px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full mb-1">
                                                    Gudang: {{ $o->stok_gudang }}
                                                </span>
                                            @endif
                                            @if($isFarmasiLow)
                                                <span class="inline-block px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">
                                                    Farmasi: {{ $stokFarmasi }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                                @if(
            $obat->filter(function ($o) {
                $stokFarmasi = $o->stokFarmasi ? $o->stokFarmasi->jumlah : 0;
                return $o->stok_gudang < 10 || ($o->stokFarmasi && $stokFarmasi <= $o->stokFarmasi->stok_minimum);
            })->count() > 5
        )
                                            <div class="text-center pt-2">
                                                <a href="{{ route('dashboard.gudang.obat.index') }}?filter=critical"
                                                    class="text-sm text-blue-600 hover:text-blue-700">
                                                    +{{ $obat->filter(function ($o) {
                $stokFarmasi = $o->stokFarmasi ? $o->stokFarmasi->jumlah : 0;
                return $o->stok_gudang < 10 || ($o->stokFarmasi && $stokFarmasi <= $o->stokFarmasi->stok_minimum);
            })->count() - 5 }} obat lainnya
                                                </a>
                                            </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-600 font-medium">Semua Stok dalam Kondisi Baik</p>
                                <p class="text-slate-500 text-sm">Tidak ada obat yang memerlukan perhatian khusus</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
                        <h3 class="font-semibold text-slate-800">📈 Ringkasan Stok</h3>
                        <a href="{{ route('dashboard.gudang.obat.index') }}"
                            class="text-xs text-blue-600 hover:text-blue-700 font-medium">Detail</a>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 p-4 rounded-lg border border-blue-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-blue-600 font-medium">Total Obat</p>
                                        <p class="text-2xl font-bold text-blue-700">{{ $totalObat }}</p>
                                    </div>
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gradient-to-r from-emerald-50 to-green-50 p-4 rounded-lg border border-emerald-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-emerald-600 font-medium">Stok Aman</p>
                                        <p class="text-2xl font-bold text-emerald-700">
                                            {{ $totalObat - $stokRendah - $stokFarmasiRendah }}
                                        </p>
                                    </div>
                                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            @if($stokRendah > 0)
                                <div class="bg-gradient-to-r from-red-50 to-pink-50 p-4 rounded-lg border border-red-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-red-600 font-medium">Stok Gudang Rendah</p>
                                            <p class="text-2xl font-bold text-red-700">{{ $stokRendah }}</p>
                                        </div>
                                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($stokFarmasiRendah > 0)
                                <div class="bg-gradient-to-r from-amber-50 to-yellow-50 p-4 rounded-lg border border-amber-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-amber-600 font-medium">Perlu Distribusi</p>
                                            <p class="text-2xl font-bold text-amber-700">{{ $stokFarmasiRendah }}</p>
                                        </div>
                                        <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if($stokRendah == 0 && $stokFarmasiRendah == 0)
                            <div class="mt-4 text-center py-4">
                                <div class="inline-flex items-center px-3 py-2 bg-green-100 rounded-full">
                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-green-700">Semua stok dalam kondisi optimal</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal untuk terima barang -->
            <div id="receiveModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
                    <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeReceiveModal()"></div>

                    <div
                        class="relative inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Terima Barang dari Supplier</h3>

                        <form id="receiveForm" method="POST" action="{{ route('gudang.stok.receive') }}">
                            @csrf
                            <input type="hidden" name="obat_id" id="receiveObatId">

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Obat</label>
                                <div id="receiveObatName"
                                    class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-gray-900"></div>
                            </div>

                            <div class="mb-4">
                                <label for="jumlah_terima" class="block text-sm font-medium text-gray-700 mb-1">Jumlah
                                    Diterima</label>
                                <input type="number" name="jumlah_terima" id="jumlah_terima"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    required min="1">
                            </div>

                            <div class="mb-6">
                                <label for="lokasi_rak" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Rak
                                    (Opsional)</label>
                                <input type="text" name="lokasi_rak" id="lokasi_rak"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="Contoh: Rak A-1, Lantai 2">
                            </div>

                            <div class="flex gap-3 justify-end">
                                <button type="button" onclick="closeReceiveModal()"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors">
                                    💾 Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                function openReceiveModal(obatId, obatName) {
                    document.getElementById('receiveObatId').value = obatId;
                    document.getElementById('receiveObatName').textContent = obatName;
                    document.getElementById('receiveModal').classList.remove('hidden');
                    document.getElementById('jumlah_terima').focus();
                }

                function closeReceiveModal() {
                    document.getElementById('receiveModal').classList.add('hidden');
                    document.getElementById('receiveForm').reset();
                }
            </script>
@endsection