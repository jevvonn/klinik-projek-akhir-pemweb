<!DOCTYPE html>
<html>

<head>
    <title>Debug Request Detail</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 3px;
            color: white;
        }

        .badge-pending {
            background-color: #f59e0b;
        }

        .badge-approved {
            background-color: #10b981;
        }

        .badge-rejected {
            background-color: #ef4444;
        }

        .badge-fulfilled {
            background-color: #3b82f6;
        }
    </style>
</head>

<body>
    <h1>DEBUG: Detail Request: {{ $request->kode }}</h1>

    <div style="margin-bottom: 20px;">
        <p><strong>ID:</strong> {{ $request->id }}</p>
        <p><strong>Status:</strong> <span
                class="badge badge-{{ $request->status }}">{{ ucfirst($request->status) }}</span></p>
        <p><strong>Created:</strong> {{ $request->created_at->format('d/m/Y H:i') }}</p>
        @if($request->catatan)
            <p><strong>Catatan:</strong> {{ $request->catatan }}</p>
        @endif
    </div>

    <h3>Items ({{ $request->items->count() }})</h3>

    @if($request->items->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Obat ID</th>
                    <th>Nama Obat</th>
                    <th>Kode Obat</th>
                    <th>Stok Gudang</th>
                    <th>Qty Diminta</th>
                    <th>Qty Dikirim</th>
                </tr>
            </thead>
            <tbody>
                @foreach($request->items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->obat_id }}</td>
                        <td>
                            @if($item->obat)
                                {{ $item->obat->nama_obat }}
                            @else
                                <em>Obat not found</em>
                            @endif
                        </td>
                        <td>
                            @if($item->obat)
                                {{ $item->obat->kode_obat }}
                            @else
                                <em>N/A</em>
                            @endif
                        </td>
                        <td>
                            @if($item->obat)
                                {{ number_format($item->obat->stok_gudang) }}
                            @else
                                <em>N/A</em>
                            @endif
                        </td>
                        <td>{{ number_format($item->qty_diminta) }}</td>
                        <td>{{ number_format($item->qty_dikirim) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No items found.</p>
    @endif

    <h3>Raw Data Debug</h3>
    <pre>{{ print_r($request->toArray(), true) }}</pre>
</body>

</html>