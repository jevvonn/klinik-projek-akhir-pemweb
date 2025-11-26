@extends('dashboard.farmasi.templateFarmasi')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Data Obat</h1>
    </div>

    <!-- BUTTON: Menggunakan mb-3 untuk memberi jarak ke elemen bawahnya --> 
    <a href="{{ route('obat.create') }}" class="btn btn-primary mb-3">Tambah Obat</a>
  
    <!-- ALERT: Ditambahkan mb-3 agar ada jarak antara alert dan tabel jika alert muncul -->
    @if(session('success'))
        <div style="background:#bbf7d0;padding:8px 10px;border-radius:8px;margin-bottom:10px;font-size:13px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLE: Menggunakan mt-4 (Margin Top) agar jarak ke atas lebih lega -->
    <div class="table-responsive">
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Obat</th>
                    <th>Bentuk</th>
                    <th>Jumlah (mg)</th>
                    <th>Kategori</th>
                    <th>Harga Jual</th>
                    <th>Status</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($obat as $o)
                <tr>
                    <td>{{ $o->kode_obat }}</td>
                    <td>{{ $o->nama_obat }}</td>
                    <td>{{ $o->bentuk }}</td>
                    <td>{{ $o->jumlah }}</td>
                    <td>{{ $o->kategori }}</td>
                    <td>{{ number_format($o->harga_jual,0,',','.') }}</td>
                    <td>
                        <span class="badge {{ $o->status_aktif ? 'bg-success' : 'bg-danger' }}">
                            {{ $o->status_aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('obat.edit', $o->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('obat.destroy', $o->id) }}" method="POST" style="display:inline-block"
                              onsubmit="return confirm('Yakin hapus obat ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center">Belum ada data obat.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $obat->links() }}
    </div>
@endsection