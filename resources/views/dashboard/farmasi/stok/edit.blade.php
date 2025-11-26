@extends('dashboard.farmasi.templateFarmasi')

@section('content')
    <h2 style="margin-top:0;font-size:18px;margin-bottom:12px;">
        Ubah Stok Obat: {{ $obat->nama_obat }}
    </h2>

    @if ($errors->any())
        <div style="background:#fee2e2;padding:8px 10px;border-radius:8px;margin-bottom:10px;font-size:13px;">
            <ul style="margin:0;padding-left:18px;">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $stok = $obat->stokFarmasi;
    @endphp

    <form action="{{ route('farmasi.stok.update', $obat->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3" style="margin-bottom:10px;">
            <label style="display:block;font-size:14px;margin-bottom:4px;">Jumlah Saat Ini</label>
            <input type="number" min="0" name="qty" class="form-control"
                value="{{ old('qty', $stok ? $stok->jumlah : $obat->jumlah ?? 0) }}"
                style="width:200px;padding:6px 8px;border-radius:8px;border:1px solid #d1d5db;">
        </div>

        <div class="mb-3" style="margin-bottom:10px;">
            <label style="display:block;font-size:14px;margin-bottom:4px;">Stok Minimum</label>
            <input type="number" min="0" name="stok_minimum" class="form-control"
                value="{{ old('stok_minimum', $stok->stok_minimum ?? 10) }}"
                style="width:200px;padding:6px 8px;border-radius:8px;border:1px solid #d1d5db;">
        </div>

        <div style="margin-top:14px;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('dashboard-farmasi') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
@endsection