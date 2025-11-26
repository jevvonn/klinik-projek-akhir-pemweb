<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Supplier;
use App\Models\TransactionHistory;
use App\Models\StokFarmasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GudangController extends Controller
{
    protected function checkGudangAccess()
    {
        if (Auth::user()->role !== 'ADMIN_GUDANG') {
            abort(403, 'Unauthorized access to Gudang module');
        }
    }

    public function index()
    {
        $this->checkGudangAccess();

        $title = 'Dashboard Gudang';
        $obat = Obat::with(['supplier', 'stokFarmasi'])
            ->orderBy('nama_obat')
            ->get();

        // Stats for dashboard
        $totalObat = $obat->count();
        $requestsPending = \App\Models\GudangRequest::where('status', 'pending')->count();
        $stokRendah = $obat->filter(function ($o) {
            return $o->stok_gudang < 10;
        })->count();

        // NEW: Alert untuk stok farmasi rendah
        $stokFarmasiRendah = $obat->filter(function ($o) {
            $stokFarmasi = $o->stokFarmasi;
            if (!$stokFarmasi)
                return false;
            return $stokFarmasi->jumlah <= $stokFarmasi->stok_minimum;
        })->count();

        // NEW: Auto-create requests untuk stok farmasi yang rendah
        $this->checkAndCreateAutoRequests($obat);

        $supplierAktif = \App\Models\Supplier::count();

        return view('dashboard.gudang.index', compact(
            'title',
            'obat',
            'totalObat',
            'requestsPending',
            'stokRendah',
            'stokFarmasiRendah',
            'supplierAktif'
        ));
    }

    public function history()
    {
        $this->checkGudangAccess();

        $title = 'Riwayat Transaksi Gudang';
        $histories = TransactionHistory::with(['obat'])
            ->latest()
            ->paginate(20);

        return view('dashboard.gudang.history', compact('title', 'histories'));
    }

    public function receiveFromSupplier(Request $request)
    {
        $this->checkGudangAccess();

        $validated = $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jumlah_terima' => 'required|integer|min:1',
            'lokasi_rak' => 'nullable|string|max:50',
        ]);

        $obat = Obat::findOrFail($validated['obat_id']);
        $stokLama = $obat->stok_gudang;
        $stokBaru = $stokLama + $validated['jumlah_terima'];

        // Update stok gudang
        $obat->update([
            'stok_gudang' => $stokBaru,
            'lokasi_rak' => $validated['lokasi_rak'] ?? $obat->lokasi_rak,
        ]);

        // Log transaction
        TransactionHistory::logTransaction(
            $obat->id,
            'receive_from_supplier',
            $validated['jumlah_terima'],
            $stokLama,
            $stokBaru,
            'Penerimaan barang dari supplier'
        );

        return redirect()->back()
            ->with('ok', 'Barang berhasil diterima dari supplier.');
    }

    // ===== AUTO-REQUEST MONITORING =====

    private function checkAndCreateAutoRequests($obatCollection)
    {
        foreach ($obatCollection as $obat) {
            $stokFarmasi = $obat->stokFarmasi;
            if (!$stokFarmasi)
                continue;

            $stokMinimum = $stokFarmasi->stok_minimum ?? 10;

            // Cek apakah stok farmasi <= minimum DAN ada stok di gudang
            if ($stokFarmasi->jumlah <= $stokMinimum && $obat->stok_gudang > 0) {

                // Cek apakah sudah ada request pending/approved untuk obat ini dalam 24 jam terakhir
                $existingRequest = \App\Models\GudangRequest::whereHas('items', function ($query) use ($obat) {
                    $query->where('obat_id', $obat->id);
                })
                    ->whereIn('status', ['pending', 'approved']) // PERBAIKAN: Cek pending DAN approved
                    ->where('requested_by', 'auto_system')
                    ->where('created_at', '>=', now()->subDay())
                    ->exists();

                if (!$existingRequest) {
                    // Auto-create request
                    $qtyRequest = min($stokMinimum * 3, $obat->stok_gudang); // Request 3x minimum atau sesuai stok

                    GudangRequestController::createFromFarmasi(
                        $obat->id,
                        $qtyRequest,
                        "🚨 AUTO-ALERT: Stok farmasi {$obat->nama_obat} rendah ({$stokFarmasi->jumlah}/{$stokMinimum}). Perlu restock segera!",
                        'auto_system'
                    );
                }
            }
        }
    }

    // ===== OBAT MANAGEMENT =====

    public function obatIndex()
    {
        $this->checkGudangAccess();

        $obat = Obat::with(['supplier', 'stokFarmasi'])
            ->orderBy('nama_obat')
            ->paginate(15);

        return view('dashboard.gudang.obat.index', compact('obat'));
    }

    public function obatCreate()
    {
        $this->checkGudangAccess();

        $suppliers = \App\Models\Supplier::all();
        return view('dashboard.gudang.obat.create', compact('suppliers'));
    }

    public function obatStore(\Illuminate\Http\Request $request)
    {
        $this->checkGudangAccess();

        $request->validate([
            'kode_obat' => 'required|string|max:50|unique:obat,kode_obat',
            'nama_obat' => 'required|string|max:150',
            'bentuk' => 'nullable|string|max:50',
            'kategori' => 'nullable|string|max:100',
            'harga_jual' => 'required|numeric|min:0',
            'stok_gudang' => 'required|integer|min:0',
            'status_aktif' => 'nullable|boolean',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'lokasi_rak' => 'nullable|string|max:255',
        ]);

        // Set default value for status_aktif if not provided
        $data = $request->all();
        $data['status_aktif'] = $request->input('status_aktif', 1);

        Obat::create($data);

        return redirect()->route('dashboard.gudang.obat.index')
            ->with('success', 'Obat berhasil ditambahkan');
    }

    public function obatEdit(Obat $obat)
    {
        $this->checkGudangAccess();

        $suppliers = \App\Models\Supplier::all();
        return view('dashboard.gudang.obat.edit', compact('obat', 'suppliers'));
    }

    public function obatUpdate(\Illuminate\Http\Request $request, Obat $obat)
    {
        $this->checkGudangAccess();

        $request->validate([
            'kode_obat' => 'required|string|max:50|unique:obat,kode_obat,' . $obat->id,
            'nama_obat' => 'required|string|max:150',
            'bentuk' => 'nullable|string|max:50',
            'kategori' => 'nullable|string|max:100',
            'harga_jual' => 'required|numeric|min:0',
            'stok_gudang' => 'required|integer|min:0',
            'status_aktif' => 'required|boolean',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'lokasi_rak' => 'nullable|string|max:255',
        ]);

        $obat->update($request->all());

        return redirect()->route('dashboard.gudang.obat.index')
            ->with('success', 'Obat berhasil diperbarui');
    }

    public function obatDestroy(Obat $obat)
    {
        $this->checkGudangAccess();

        $obat->delete();

        return redirect()->route('dashboard.gudang.obat.index')
            ->with('success', 'Obat berhasil dihapus');
    }
}