@extends('dashboard.gudang.template')
@section('title', 'Edit Obat')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center mb-6">
            <a href="{{ route('dashboard.gudang.obat.index') }}"
                class="mr-4 p-2 text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Obat</h1>
                <p class="text-slate-600">Perbarui data obat {{ $obat->nama_obat }}</p>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <h3 class="text-sm font-medium text-red-800 mb-2">Terjadi kesalahan:</h3>
                <ul class="text-sm text-red-600 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                <h3 class="font-semibold text-slate-800">Informasi Obat</h3>
            </div>

            <form method="POST" action="{{ route('dashboard.gudang.obat.update', $obat->id) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <div>
                            <label for="kode_obat" class="block text-sm font-medium text-slate-700 mb-2">Kode Obat *</label>
                            <input type="text" name="kode_obat" id="kode_obat"
                                value="{{ old('kode_obat', $obat->kode_obat) }}"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('kode_obat') border-red-300 @enderror"
                                required>
                            @error('kode_obat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nama_obat" class="block text-sm font-medium text-slate-700 mb-2">Nama Obat *</label>
                            <input type="text" name="nama_obat" id="nama_obat"
                                value="{{ old('nama_obat', $obat->nama_obat) }}"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('nama_obat') border-red-300 @enderror"
                                required>
                            @error('nama_obat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bentuk" class="block text-sm font-medium text-slate-700 mb-2">Bentuk</label>
                            <select name="bentuk" id="bentuk"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                <option value="">Pilih bentuk obat</option>
                                <option value="Tablet" {{ old('bentuk', $obat->bentuk) == 'Tablet' ? 'selected' : '' }}>Tablet
                                </option>
                                <option value="Kapsul" {{ old('bentuk', $obat->bentuk) == 'Kapsul' ? 'selected' : '' }}>Kapsul
                                </option>
                                <option value="Sirup" {{ old('bentuk', $obat->bentuk) == 'Sirup' ? 'selected' : '' }}>Sirup
                                </option>
                                <option value="Injeksi" {{ old('bentuk', $obat->bentuk) == 'Injeksi' ? 'selected' : '' }}>
                                    Injeksi</option>
                                <option value="Salep" {{ old('bentuk', $obat->bentuk) == 'Salep' ? 'selected' : '' }}>Salep
                                </option>
                                <option value="Drop" {{ old('bentuk', $obat->bentuk) == 'Drop' ? 'selected' : '' }}>Drop
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="kategori" class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                            <select name="kategori" id="kategori"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                <option value="">Pilih kategori</option>
                                <option value="Analgesik" {{ old('kategori', $obat->kategori) == 'Analgesik' ? 'selected' : '' }}>Analgesik</option>
                                <option value="Antibiotik" {{ old('kategori', $obat->kategori) == 'Antibiotik' ? 'selected' : '' }}>Antibiotik</option>
                                <option value="Vitamin" {{ old('kategori', $obat->kategori) == 'Vitamin' ? 'selected' : '' }}>
                                    Vitamin</option>
                                <option value="NSAID" {{ old('kategori', $obat->kategori) == 'NSAID' ? 'selected' : '' }}>
                                    NSAID</option>
                                <option value="Antiseptik" {{ old('kategori', $obat->kategori) == 'Antiseptik' ? 'selected' : '' }}>Antiseptik</option>
                                <option value="Antasida" {{ old('kategori', $obat->kategori) == 'Antasida' ? 'selected' : '' }}>Antasida</option>
                            </select>
                        </div>

                        <div>
                            <label for="status_aktif" class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                            <select name="status_aktif" id="status_aktif"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                required>
                                <option value="1" {{ old('status_aktif', $obat->status_aktif) == 1 ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="0" {{ old('status_aktif', $obat->status_aktif) == 0 ? 'selected' : '' }}>
                                    Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <div>
                            <label for="supplier_id" class="block text-sm font-medium text-slate-700 mb-2">Supplier</label>
                            <select name="supplier_id" id="supplier_id"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                <option value="">Pilih supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $obat->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="harga_jual" class="block text-sm font-medium text-slate-700 mb-2">Harga Jual
                                *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="harga_jual" id="harga_jual"
                                    value="{{ old('harga_jual', $obat->harga_jual) }}"
                                    class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('harga_jual') border-red-300 @enderror"
                                    min="0" step="100" required>
                            </div>
                            @error('harga_jual')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stok_gudang" class="block text-sm font-medium text-slate-700 mb-2">Stok Gudang
                                *</label>
                            <input type="number" name="stok_gudang" id="stok_gudang"
                                value="{{ old('stok_gudang', $obat->stok_gudang) }}"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('stok_gudang') border-red-300 @enderror"
                                min="0" required>
                            <p class="mt-1 text-xs text-slate-500">Perubahan stok akan dicatat dalam history</p>
                            @error('stok_gudang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="lokasi_rak" class="block text-sm font-medium text-slate-700 mb-2">Lokasi Rak</label>
                            <input type="text" name="lokasi_rak" id="lokasi_rak"
                                value="{{ old('lokasi_rak', $obat->lokasi_rak) }}"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                placeholder="Rak A-1, Lantai 2">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between pt-6 border-t border-slate-200 mt-6">
                    <a href="{{ route('dashboard.gudang.obat.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-lg hover:shadow-xl font-medium">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Current Stock Info -->
        <div class="mt-6 bg-slate-50 rounded-xl border border-slate-200 p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Informasi Stok Saat Ini</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="text-sm text-slate-600">Stok Gudang</div>
                    <div class="text-2xl font-bold text-green-600">{{ number_format($obat->stok_gudang) }}</div>
                </div>
                <div>
                    <div class="text-sm text-slate-600">Stok Farmasi</div>
                    <div class="text-2xl font-bold text-blue-600">{{ number_format($obat->stokFarmasi->jumlah ?? 0) }}</div>
                </div>
            </div>
            @if($obat->lokasi_rak)
                <div class="mt-4 text-sm text-slate-600">
                    📍 Lokasi: <span class="font-medium">{{ $obat->lokasi_rak }}</span>
                </div>
            @endif
        </div>
    </div>
@endsection