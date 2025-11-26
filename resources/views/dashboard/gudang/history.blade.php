@extends('dashboard.gudang.template')

@section('content')
    <h1>Riwayat Transaksi Gudang</h1>
    <p style="color:#666;margin-bottom:20px;">Log semua transaksi masuk dan keluar gudang</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Obat</th>
                <th>Aksi</th>
                <th>Qty</th>
                <th>Stok Sebelum</th>
                <th>Stok Sesudah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($histories as $history)
                <tr>
                    <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <strong>{{ $history->obat->nama_obat }}</strong><br>
                        <small style="color:#666;">{{ $history->obat->kode_obat }}</small>
                    </td>
                    <td>
                        @php
                            $aksiLabels = [
                                'receive_from_supplier' => ['Terima dari Supplier', '#16a34a'],
                                'send_to_farmasi' => ['Kirim ke Farmasi', '#2563eb'],
                                'request_from_farmasi' => ['Request dari Farmasi', '#f59e0b'],
                                'manual_adjustment' => ['Penyesuaian Manual', '#6b7280'],
                            ];
                            [$label, $color] = $aksiLabels[$history->aksi] ?? [$history->aksi, '#6b7280'];
                        @endphp
                        <span style="color:{{ $color }};font-weight:500;">
                            {{ $label }}
                        </span>
                    </td>
                    <td>
                        <strong
                            style="color:{{ in_array($history->aksi, ['receive_from_supplier', 'manual_adjustment']) && $history->qty > 0 ? '#16a34a' : '#ef4444' }}">
                            {{ $history->aksi === 'send_to_farmasi' ? '-' : '+' }}{{ number_format($history->qty) }}
                        </strong>
                    </td>
                    <td>{{ number_format($history->stok_sebelum ?? 0) }}</td>
                    <td>{{ number_format($history->stok_sesudah ?? 0) }}</td>
                    <td>
                        {{ $history->keterangan }}
                        @if($history->reference_code)
                            <br><small style="color:#666;">Ref: {{ $history->reference_code }}</small>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:40px;">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px;">
        {{ $histories->links() }}
    </div>
@endsection