@extends('dashboard.gudang.template')
@section('title', 'Tambah Obat Baru')

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
                <h1 class="text-2xl font-bold text-slate-800">Tambah Obat Baru</h1>
                <p class="text-slate-600">Tambahkan obat baru ke gudang dengan stok awal</p>
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

            <form method="POST" action="{{ route('dashboard.gudang.obat.store') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kode_obat" class="block text-sm font-medium text-slate-700 mb-2">Kode Obat</label>
                        <input type="text" name="kode_obat" id="kode_obat" value="{{ old('kode_obat') }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('kode_obat') border-red-300 @enderror"
                            required placeholder="Contoh: OBT001">
                        @error('kode_obat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_obat" class="block text-sm font-medium text-slate-700 mb-2">Nama Obat</label>
                        <input type="text" name="nama_obat" id="nama_obat" value="{{ old('nama_obat') }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('nama_obat') border-red-300 @enderror"
                            required placeholder="Contoh: Paracetamol">
                        @error('nama_obat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bentuk" class="block text-sm font-medium text-slate-700 mb-2">Bentuk Obat</label>
                        <select name="bentuk" id="bentuk"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('bentuk') border-red-300 @enderror">
                            <option value="">Pilih Bentuk Obat</option>
                            <option value="Tablet" {{ old('bentuk') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Kapsul" {{ old('bentuk') == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                            <option value="Sirup" {{ old('bentuk') == 'Sirup' ? 'selected' : '' }}>Sirup</option>
                            <option value="Injeksi" {{ old('bentuk') == 'Injeksi' ? 'selected' : '' }}>Injeksi</option>
                            <option value="Salep" {{ old('bentuk') == 'Salep' ? 'selected' : '' }}>Salep</option>
                            <option value="Drop" {{ old('bentuk') == 'Drop' ? 'selected' : '' }}>Drop</option>
                            <option value="Suppositoria" {{ old('bentuk') == 'Suppositoria' ? 'selected' : '' }}>Suppositoria
                            </option>
                            <option value="Inhaler" {{ old('bentuk') == 'Inhaler' ? 'selected' : '' }}>Inhaler</option>
                            <option value="Patch" {{ old('bentuk') == 'Patch' ? 'selected' : '' }}>Patch</option>
                            <option value="Gel" {{ old('bentuk') == 'Gel' ? 'selected' : '' }}>Gel</option>
                        </select>
                        @error('bentuk')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kategori" class="block text-sm font-medium text-slate-700 mb-2">Kategori Obat</label>
                        <select name="kategori" id="kategori"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('kategori') border-red-300 @enderror">
                            <option value="">Pilih Kategori</option>
                            <option value="Resep" {{ old('kategori') == 'Resep' ? 'selected' : '' }}>Obat Resep</option>
                            <option value="Bebas" {{ old('kategori') == 'Bebas' ? 'selected' : '' }}>Obat Bebas</option>
                            <option value="Bebas Terbatas" {{ old('kategori') == 'Bebas Terbatas' ? 'selected' : '' }}>Bebas
                                Terbatas</option>
                            <option value="Narkotika" {{ old('kategori') == 'Narkotika' ? 'selected' : '' }}>Narkotika
                            </option>
                            <option value="Psikotropika" {{ old('kategori') == 'Psikotropika' ? 'selected' : '' }}>
                                Psikotropika</option>
                        </select>
                        @error('kategori')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="supplier_id" class="block text-sm font-medium text-slate-700 mb-2">Supplier</label>
                        <select name="supplier_id" id="supplier_id"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('supplier_id') border-red-300 @enderror">
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="harga_jual" class="block text-sm font-medium text-slate-700 mb-2">Harga Jual</label>
                        <input type="number" name="harga_jual" id="harga_jual" value="{{ old('harga_jual') }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('harga_jual') border-red-300 @enderror"
                            required min="0" placeholder="Contoh: 5000">
                        @error('harga_jual')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stok_gudang" class="block text-sm font-medium text-slate-700 mb-2">Stok Awal
                            Gudang</label>
                        <input type="number" name="stok_gudang" id="stok_gudang" value="{{ old('stok_gudang', 0) }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('stok_gudang') border-red-300 @enderror"
                            required min="0" placeholder="Contoh: 100">
                        @error('stok_gudang')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lokasi_rak" class="block text-sm font-medium text-slate-700 mb-2">Lokasi Rak</label>
                        <input type="text" name="lokasi_rak" id="lokasi_rak" value="{{ old('lokasi_rak') }}"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('lokasi_rak') border-red-300 @enderror"
                            placeholder="Contoh: A1-01">
                        @error('lokasi_rak')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status_aktif" class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                        <select name="status_aktif" id="status_aktif"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('status_aktif') border-red-300 @enderror"
                            required>
                            <option value="1" {{ old('status_aktif', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('status_aktif') == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status_aktif')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('dashboard.gudang.obat.index') }}"
                        class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors">
                        💊 Simpan Obat
                    </button>
                </div>
            </form>
        </div>

        <!-- Tips Card -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h4 class="font-medium text-blue-800 mb-1">Tips Menambah Obat</h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Kode obat harus unik dan mudah diingat</li>
                        <li>• Stok awal akan disimpan di gudang, farmasi dimulai dari 0</li>
                        <li>• Supplier bisa dikosongkan jika obat dari sumber internal</li>
                        <li>• Harga jual akan digunakan untuk kalkulasi biaya pasien</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection