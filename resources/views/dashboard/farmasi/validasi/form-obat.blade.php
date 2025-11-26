@extends('dashboard.farmasi.templateFarmasi')

@section('content')
    <h2 style="margin-top:0;font-size:18px;margin-bottom:10px;">
        Validasi Obat untuk Pasien {{ $request->nama }}
    </h2>

    <div style="margin-bottom:14px;font-size:14px;padding:10px 12px;border-radius:10px;background:#e5f4ff;">
        <div><strong>Nama Pasien:</strong> {{ $request->nama }}</div>
        <div><strong>Dokter:</strong> {{ $request->dokter }}</div>
        <div><strong>Diagnosa:</strong> {{ $request->diagnosa }}</div>
        <div style="margin-top:6px;">
            <strong>Resep / Instruksi Obat:</strong>
            <div style="white-space:pre-wrap;">{{ $request->resep_obat }}</div>
        </div>
    </div>

    @if ($errors->any())
        <div style="background:#fee2e2;padding:8px 10px;border-radius:8px;margin-bottom:10px;font-size:13px;">
            <ul style="margin:0;padding-left:18px;">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('farmasi.validasi.obat.process', $request->id) }}" method="POST">
        @csrf

        <div style="margin-bottom:10px;">
            <label style="display:block;font-size:14px;margin-bottom:4px;">Pilih Obat</label>
            <select name="obat_id"
                    style="width:100%;max-width:400px;padding:6px 8px;border-radius:8px;border:1px solid #d1d5db;">
                <option value="">- Pilih Obat -</option>
                @foreach($obats as $obat)
                    @php
                        // ambil stok dari tabel stok_farmasi kalau ADA recordnya
                        $stokFarmasi = $obat->stokFarmasi->jumlah ?? null;

                        // kalau stok_farmasi belum ada / null → pakai jumlah dari tabel obat
                        $stok = $stokFarmasi !== null ? $stokFarmasi : ($obat->jumlah ?? 0);
                    @endphp

                    <option value="{{ $obat->id }}"
                            {{ $stok <= 0 ? 'disabled' : '' }}
                            {{ old('obat_id') == $obat->id ? 'selected' : '' }}>
                        {{ $obat->kode_obat }} - {{ $obat->nama_obat }}
                        (Stok: {{ $stok <= 0 ? 'Habis' : $stok }})
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:10px;">
            <label style="display:block;font-size:14px;margin-bottom:4px;">Jumlah Obat yang Dikirim</label>
            <input type="number" name="qty" min="1"
                   value="{{ old('qty', 1) }}"
                   style="width:120px;padding:6px 8px;border-radius:8px;border:1px solid #d1d5db;">
        </div>

        <div style="margin-top:16px;">
            <button type="submit" class="btn btn-primary">
                Validasi
            </button>
            <a href="{{ route('farmasi.validasi.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </form>
@endsection
