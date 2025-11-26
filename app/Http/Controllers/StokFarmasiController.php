<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\StokFarmasi;
use Illuminate\Http\Request;

class StokFarmasiController extends Controller
{
    // HALAMAN LIST STOK FARMASI
    public function index()
    {
        $title = 'Stok Farmasi';

        // Ambil semua obat + relasi stok farmasi (boleh kosong)
        $obat = Obat::with('stokFarmasi')
            ->orderBy('nama_obat')
            ->paginate(15);

        return view('dashboard.farmasi.stok.index', compact('title', 'obat'));
    }

    // FORM EDIT STOK UNTUK 1 OBAT
    public function edit($obatId)
    {
        $title = 'Ubah Stok Obat';

        $obat = Obat::with('stokFarmasi')->findOrFail($obatId);

        return view('dashboard.farmasi.stok.edit', compact('title', 'obat'));
    }

    // UPDATE STOK OBAT
    public function update(Request $request, $obatId)
    {
        $request->validate([
            'qty'           => 'required|integer|min:0',
            'stok_minimum'  => 'required|integer|min:0',
        ]);

        $obat = Obat::findOrFail($obatId);

        $stok = StokFarmasi::firstOrCreate(
            ['obat_id' => $obat->id],
            ['qty' => 0, 'stok_minimum' => 10]
        );

        $stok->update([
            'jumlah'          => $request->qty,
            'stok_minimum' => $request->stok_minimum,
        ]);

        // sinkron juga ke tabel obat
        $obat->update([
            'jumlah' => $request->qty,
        ]);

        return redirect()->route('dashboard-farmasi')
            ->with('success', 'Stok obat berhasil diperbarui.');
    }
}
