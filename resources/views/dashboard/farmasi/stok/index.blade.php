@extends('dashboard.farmasi.templateFarmasi')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <h1>Stok Farmasi</h1>
    </div>

    @if(session('success'))
        <div style="background:#bbf7d0;padding:8px 10px;border-radius:8px;margin-bottom:10px;font-size:13px;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Obat</th>
                <th>Jumlah (mg)</th>
                <th>Stok Minimum</th>
                <th>Status</th>
                <th style="width:120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($obat as $o)
                @php
                    $stok = $o->stokFarmasi;
                    // kalau stok_farmasi ada → pakai jumlah-nya,
                    // kalau tidak ada → pakai jumlah dari tabel obat
                    $qty = $stok ? $stok->jumlah : ($o->jumlah ?? 0);
                    $min = $stok ? $stok->stok_minimum : 10;
                    $kritis = $qty < $min;
                @endphp
                <tr>
                    <td>{{ $o->kode_obat }}</td>
                    <td>{{ $o->nama_obat }}</td>
                    <td>{{ number_format($qty) }}</td>
                    <td>{{ $min }}</td>
                    <td>
                        @if($kritis)
                            <span style="color:#b91c1c;font-weight:600;">Kritis</span>
                        @else
                            <span style="color:#15803d;">Aman</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('farmasi.stok.edit', $o->id) }}" class="btn btn-primary"
                            style="padding: 8px 16px; border-radius: 6px; text-decoration: none; border:none; cursor: pointer; display: inline-block;">
                            Ubah Stok
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:10px;">
        {{ $obat->links() }}
    </div>
@endsection