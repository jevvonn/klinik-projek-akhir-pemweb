<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\StokFarmasi;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObatController extends Controller
{
    protected function checkFarmasiAccess()
    {
        if (Auth::user()->role !== 'ADMIN_FARMASI') {
            abort(403, 'Unauthorized access. Only Farmasi can manage obat.');
        }
    }

    // LIST obat
    public function index()
    {
        $this->checkFarmasiAccess();
        $title = 'Data Obat';
        $obat = Obat::orderBy('nama_obat')->paginate(15);
        return view('dashboard.farmasi.obat.index', compact('title', 'obat'));
    }

    // FORM TAMBAH
    public function create()
    {
        $this->checkFarmasiAccess();
        $title = 'Tambah Obat Baru';
        $suppliers = Supplier::orderBy('nama')->get();
        return view('dashboard.farmasi.obat.create', compact('title', 'suppliers'));
    }

    // SIMPAN OBAT BARU
    public function store(Request $request)
    {
        $this->checkFarmasiAccess();
        $validated = $request->validate([
            'kode_obat' => 'required|max:50|unique:obat,kode_obat',
            'nama_obat' => 'required|max:150',
            'bentuk' => 'nullable|max:50',
            'jumlah' => 'required|numeric|min:0',
            'kategori' => 'nullable|max:100',
            'harga_jual' => 'required|numeric|min:0',
            'stok_gudang' => 'nullable|numeric|min:0',
            'lokasi_rak' => 'nullable|string|max:50',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        $validated['status_aktif'] = 1;

        $obat = Obat::create($validated);

        // otomatis sinkonisasi stok awal dengan jumlah obat
        StokFarmasi::create([
            'obat_id' => $obat->id,
            'jumlah' => $obat->jumlah,
            'stok_minimum' => 10,
        ]);

        return redirect()->route('obat.index')
            ->with('success', 'Data obat berhasil ditambahkan.');
    }

    // FORM EDIT
    public function edit($id)
    {
        $this->checkFarmasiAccess();
        $obat = Obat::with('supplier')->findOrFail($id);
        $suppliers = Supplier::orderBy('nama')->get();
        return view('dashboard.farmasi.obat.edit', compact('obat', 'suppliers'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $this->checkFarmasiAccess();
        $obat = Obat::findOrFail($id);

        $validated = $request->validate([
            'kode_obat' => 'required|max:50|unique:obat,kode_obat,' . $obat->id,
            'nama_obat' => 'required|max:150',
            'bentuk' => 'nullable|max:50',
            'jumlah' => 'required|numeric|min:0',
            'kategori' => 'nullable|max:100',
            'harga_jual' => 'required|numeric|min:0',
            'stok_gudang' => 'nullable|numeric|min:0',
            'lokasi_rak' => 'nullable|string|max:50',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'status_aktif' => 'required|boolean',
        ]);

        $obat->update($validated);

        $stok = StokFarmasi::firstOrCreate(
            ['obat_id' => $obat->id],
            ['qty' => $obat->jumlah, 'stok_minimum' => 10]
        );

        $stok->update([
            'qty' => $validated['jumlah'],
        ]);

        return redirect()->route('obat.index')
            ->with('success', 'Data obat berhasil diperbarui.');
    }

    // HAPUS
    public function destroy($id)
    {
        $this->checkFarmasiAccess();
        $obat = Obat::findOrFail($id);
        $obat->delete(); // stok_farmasi ikut kehapus karena FK onDelete('cascade')

        return redirect()->route('obat.index')
            ->with('success', 'Data obat berhasil dihapus.');
    }

    // // OPSIONAL: DETAIL
    // public function show($id)
    // {
    //     $obat = Obat::with('stokFarmasi')->findOrFail($id);
    //     return view('dashboard.farmasi.obat.show', compact('obat'));
    // }
}

