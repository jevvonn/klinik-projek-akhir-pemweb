@extends('dashboard.gudang.template')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-7xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Detail Request: {{ $gudangRequest->kode }}</h1>
            <div class="flex gap-4 items-center">
                <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                    @if($gudangRequest->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($gudangRequest->status === 'approved') bg-green-100 text-green-800
                                    @elseif($gudangRequest->status === 'rejected') bg-red-100 text-red-800
                                    @elseif($gudangRequest->status === 'fulfilled') bg-blue-100 text-blue-800
                                    @endif">
                    {{ ucfirst($gudangRequest->status) }}
                </span>
                <span class="text-gray-600">{{ $gudangRequest->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        @if($gudangRequest->catatan)
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                <strong class="text-gray-800">Catatan:</strong><br>
                <span class="text-gray-700">{{ $gudangRequest->catatan }}</span>
            </div>
        @endif

        <h3 class="text-lg font-semibold text-gray-900 mb-4">Item yang Diminta</h3>

        @if($gudangRequest->status === 'approved')
            <form id="fulfillForm" action="{{ route('dashboard.gudang.requests.fulfill', $gudangRequest) }}" method="POST">
                @csrf
        @endif

            <table class="w-full bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-6">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Obat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok
                            Gudang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty
                            Diminta</th>
                        @if($gudangRequest->status === 'approved')
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty
                                Dikirim</th>
                        @elseif($gudangRequest->status === 'fulfilled')
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty
                                Dikirim</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($gudangRequest->items as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <strong>{{ $item->obat->nama_obat }}</strong><br>
                                <small style="color:#666;">{{ $item->obat->kode_obat }}</small>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    style="font-weight:600;color:{{ $item->obat->stok_gudang >= $item->qty_diminta ? '#16a34a' : '#ef4444' }}">
                                    {{ number_format($item->obat->stok_gudang) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->qty_diminta) }}</td>
                            @if($gudangRequest->status === 'approved')
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" name="items[{{ $item->id }}][qty_dikirim]"
                                        class="border border-gray-300 rounded px-3 py-2 w-24 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        value="{{ min($item->qty_diminta, $item->obat->stok_gudang) }}" min="0"
                                        max="{{ $item->obat->stok_gudang }}">
                                </td>
                            @elseif($gudangRequest->status === 'fulfilled')
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <strong style="color:#16a34a;">{{ number_format($item->qty_dikirim) }}</strong>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex gap-3 mt-6">
                <a href="{{ route('dashboard.gudang.requests.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">Kembali</a>

                @if($gudangRequest->status === 'pending')
                    <form action="{{ route('dashboard.gudang.requests.approve', $gudangRequest) }}" method="POST"
                        class="inline">
                        @csrf
                        <button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors"
                            type="submit" onclick="return confirm('Setujui request ini?')">Approve Request</button>
                    </form>

                    <button type="button" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors"
                        onclick="openRejectModal()">Reject</button>
                @elseif($gudangRequest->status === 'approved')
                    <button type="submit" form="fulfillForm"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors"
                        onclick="return confirm('Kirim obat ke farmasi?')">Kirim ke Farmasi</button>
                @endif
            </div>

            @if($gudangRequest->status === 'approved')
                </form>
            @endif
    </div>

    {{-- Modal Reject --}}
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
        onclick="closeRejectModal()">
        <div class="bg-white rounded-lg shadow-xl p-6 w-96 max-w-md mx-4" onclick="event.stopPropagation()">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tolak Request</h3>

            <form action="{{ route('dashboard.gudang.requests.reject', $gudangRequest) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                    <textarea name="catatan"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        rows="3" required placeholder="Jelaskan alasan penolakan..."></textarea>
                </div>

                <div class="flex gap-3 justify-end mt-5">
                    <button type="button"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors"
                        onclick="closeRejectModal()">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                        Tolak Request</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
@endsection