@extends('dashboard.farmasi.templateFarmasi')
@section('content')
    <style>
        .form-container {
            background: transparent;
            min-height: 100vh;
            padding: 40px 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        .form-card {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-card h1 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 25px;
        }

        .form-group-full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            transition: all 0.2s;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
            font-family: inherit;
        }

        .alert {
            padding: 16px;
            margin-bottom: 24px;
            border-radius: 6px;
            background-color: #fee2e2;
            border: 1px solid #fecaca;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert li {
            color: #dc2626;
            font-size: 14px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .btn {
            padding: 12px 28px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: #374151;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .form-card {
                padding: 24px;
            }
        }
    </style>

    <h1>Tambah Obat</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('obat.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Kode Obat</label>
                <input type="text" name="kode_obat" class="form-control" placeholder="contoh: OBT001"
                    value="{{ old('kode_obat') }}" required>
            </div>
            <div class="form-group">
                <label>Nama Obat</label>
                <input type="text" name="nama_obat" class="form-control" placeholder="contoh: Paracetamol"
                    value="{{ old('nama_obat') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Bentuk</label>
                <select name="bentuk" class="form-control">
                    <option value="">Pilih</option>
                    <option value="Tablet" {{ old('bentuk') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="Kapsul" {{ old('bentuk') == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                    <option value="Sirup" {{ old('bentuk') == 'Sirup' ? 'selected' : '' }}>Sirup</option>
                    <option value="Injeksi" {{ old('bentuk') == 'Injeksi' ? 'selected' : '' }}>Injeksi</option>
                    <option value="Salep" {{ old('bentuk') == 'Salep' ? 'selected' : '' }}>Salep</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah (mg)</label>
                <input type="number" name="jumlah" class="form-control" placeholder="0" value="{{ old('jumlah') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" class="form-control">
                    <option value="">Pilih</option>
                    <option value="Analgesik" {{ old('kategori') == 'Analgesik' ? 'selected' : '' }}>Analgesik</option>
                    <option value="Vitamin" {{ old('kategori') == 'Vitamin' ? 'selected' : '' }}>Vitamin</option>
                    <option value="Antibiotik" {{ old('kategori') == 'Antibiotik' ? 'selected' : '' }}>Antibiotik</option>
                    <option value="NSAID" {{ old('kategori') == 'NSAID' ? 'selected' : '' }}>NSAID</option>
                </select>
            </div>
            <div class="form-group">
                <label>Harga Jual</label>
                <input type="number" step="0.01" min="0" name="harga_jual" class="form-control" placeholder="0.00"
                    value="{{ old('harga_jual', 0) }}" required>
            </div>
        </div>

        <!-- Gudang Fields -->
        <div class="form-row">
            <div class="form-group">
                <label>Stok Gudang</label>
                <input type="number" min="0" name="stok_gudang" class="form-control" placeholder="0"
                    value="{{ old('stok_gudang', 0) }}">
            </div>
            <div class="form-group">
                <label>Lokasi Rak</label>
                <input type="text" name="lokasi_rak" class="form-control" placeholder="contoh: A1-001"
                    value="{{ old('lokasi_rak') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Supplier</label>
                <select name="supplier_id" class="form-control">
                    <option value="">-- Pilih Supplier --</option>
                    @if(isset($suppliers))
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->nama }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('obat.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
@endsection