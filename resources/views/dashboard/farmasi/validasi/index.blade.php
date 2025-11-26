@extends('dashboard.farmasi.templateFarmasi')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <h2 style="margin:0;font-size:18px;">Validasi Resep Pasien</h2>
    </div>

    @if(session('success'))
        <div style="background:#bbf7d0;padding:8px 10px;border-radius:8px;margin-bottom:10px;font-size:13px;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
        <tr>
            <th>Waktu</th>
            <th>Nama Pasien</th>
            <th>Dokter</th>
            <th>Diagnosa</th>
            <th>Resep / Instruksi Obat</th>
            <th>Status</th>
            <th style="width:220px;">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @forelse($requests as $req)
            <tr>
                <td>{{ $req->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $req->nama }}</td>
                <td>{{ $req->dokter }}</td>
                <td>{{ $req->diagnosa }}</td>
                <td style="max-width:260px;">
                    <div style="font-size:13px;">
                        {{ $req->resep_obat }}
                    </div>
                </td>
                <td>
                    @if($req->status === 'pending')
                        <span style="color:#92400e;font-weight:600;">Pending</span>
                    @elseif($req->status === 'processed')
                        <span style="color:#2563eb;font-weight:600;">Processed</span>
                    @else
                        <span style="color:#15803d;font-weight:600;">Completed</span>
                    @endif
                </td>
                <td>
                    @if($req->status === 'pending')
                        {{-- ke form pilih obat --}}
                        <a href="{{ route('farmasi.validasi.obat.form', $req->id) }}"
                           class="btn btn-primary">
                            Validasi &amp; Proses
                        </a>
                    @elseif($req->status === 'processed')
                        {{-- tandai selesai + kurangi stok (sudah di controller) --}}
                        <form action="{{ route('farmasi.validasi.complete', $req->id) }}"
                              method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Tandai Selesai
                            </button>
                        </form>
                    @else
                        <em style="font: size 16px;;">Proses selesai</em>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Belum ada request resep dari Klinik.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:10px;">
        {{ $requests->links() }}
    </div>
@endsection
