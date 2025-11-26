@extends('dashboard.gudang.template')
@section('title', 'Detail Stok - ' . $obat->nama_obat)

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <a href="{{ route('dashboard.gudang.index') }}"
                    class="mr-4 p-2 text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Detail Stok Gudang</h1>
                    <p class="text-slate-600">{{ $obat->nama_obat }} - {{ $obat->kode_obat }}</p>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('dashboard.gudang.obat.edit', $obat->id) }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                    ✏️ Edit Stok
                </a>
                <a href="{{ route('dashboard.gudang.riwayat', $obat->id) }}"
                    class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">
                    📋 Riwayat
                </a>
            </div>
        </div>

        <!-- Stok Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Stok Gudang -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="h-12 w-12 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    @if($obat->stok_gudang < 10)
                        <span class="px-2 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-full">Stok Rendah</span>
                    @elseif($obat->stok_gudang < 50)
                        <span class="px-2 py-1 text-xs font-medium text-yellow-600 bg-yellow-100 rounded-full">Stok
                            Sedang</span>
                    @else
                        <span class="px-2 py-1 text-xs font-medium text-green-600 bg-green-100 rounded-full">Stok Aman</span>
                    @endif
                </div>
                <div class="mb-2">
                    <h3 class="text-sm font-medium text-slate-600 mb-1">Stok Gudang</h3>
                    <div class="text-2xl font-bold {{ $obat->stok_gudang < 10 ? 'text-red-600' : 'text-slate-800' }}">
                        {{ number_format($obat->stok_gudang) }}
                    </div>
                </div>
                <p class="text-xs text-slate-500">Unit tersedia di gudang</p>
            </div>

            <!-- Stok Farmasi -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="h-12 w-12 rounded-xl bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-full">Siap Jual</span>
                </div>
                <div class="mb-2">
                    <h3 class="text-sm font-medium text-slate-600 mb-1">Stok Farmasi</h3>
                    <div class="text-2xl font-bold text-slate-800">
                        {{ number_format($obat->stokFarmasi ? $obat->stokFarmasi->jumlah : 0) }}
                    </div>
                </div>
                <p class="text-xs text-slate-500">Unit siap dijual</p>
            </div>

            <!-- Total Stok -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium text-purple-600 bg-purple-100 rounded-full">Total</span>
                </div>
                <div class="mb-2">
                    <h3 class="text-sm font-medium text-slate-600 mb-1">Total Stok</h3>
                    <div class="text-2xl font-bold text-slate-800">
                        {{ number_format($obat->stok_gudang + ($obat->stokFarmasi ? $obat->stokFarmasi->jumlah : 0)) }}
                    </div>
                </div>
                <p class="text-xs text-slate-500">Total unit tersedia</p>
            </div>
        </div>

        <!-- Detail Information -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Informasi Obat -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h3 class="font-semibold text-slate-800">Informasi Obat</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="font-medium text-slate-600">Kode Obat</span>
                        <span class="text-slate-800 font-mono">{{ $obat->kode_obat }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="font-medium text-slate-600">Nama Obat</span>
                        <span class="text-slate-800">{{ $obat->nama_obat }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="font-medium text-slate-600">Jenis</span>
                        <span class="text-slate-800">{{ $obat->jenis ?? 'Tidak diset' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="font-medium text-slate-600">Harga</span>
                        <span class="text-slate-800">Rp {{ number_format($obat->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="font-medium text-slate-600">Lokasi Rak</span>
                        <span class="text-slate-800">{{ $obat->lokasi_rak ?? 'Belum diset' }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="font-medium text-slate-600">Supplier</span>
                        <span class="text-slate-800">{{ $obat->supplier ? $obat->supplier->nama : 'Belum diset' }}</span>
                    </div>
                </div>
            </div>

            <!-- Status Permintaan -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h3 class="font-semibold text-slate-800">Status Permintaan</h3>
                </div>
                <div class="p-6">
                    @php
                        $pendingRequests = $obat->clinicRequests()->where('status', 'pending')->count();
                        $approvedToday = $obat->clinicRequests()->where('status', 'approved')->whereDate('updated_at', today())->count();
                        $totalApproved = $obat->clinicRequests()->where('status', 'approved')->count();
                    @endphp

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-lg bg-yellow-500 flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">{{ $pendingRequests }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-yellow-800">Permintaan Pending</p>
                                    <p class="text-sm text-yellow-600">Menunggu persetujuan</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-200">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-lg bg-green-500 flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">{{ $approvedToday }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-green-800">Disetujui Hari Ini</p>
                                    <p class="text-sm text-green-600">{{ date('d F Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-lg bg-blue-500 flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">{{ $totalApproved }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-blue-800">Total Disetujui</p>
                                    <p class="text-sm text-blue-600">Sepanjang waktu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-6 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                <h3 class="font-semibold text-slate-800">Aksi Cepat</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('dashboard.gudang.obat.edit', $obat->id) }}"
                        class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition-colors">
                        <div class="h-10 w-10 rounded-lg bg-blue-500 flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-blue-800">Edit Stok</p>
                            <p class="text-sm text-blue-600">Update stok gudang</p>
                        </div>
                    </a>

                    <a href="{{ route('dashboard.gudang.riwayat', $obat->id) }}"
                        class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg border border-green-200 transition-colors">
                        <div class="h-10 w-10 rounded-lg bg-green-500 flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-green-800">Lihat Riwayat</p>
                            <p class="text-sm text-green-600">Transaksi & mutasi</p>
                        </div>
                    </a>

                    <a href="{{ route('dashboard.gudang.permintaan.index') }}"
                        class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg border border-purple-200 transition-colors">
                        <div class="h-10 w-10 rounded-lg bg-purple-500 flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-purple-800">Kelola Permintaan</p>
                            <p class="text-sm text-purple-600">Pending & riwayat</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection