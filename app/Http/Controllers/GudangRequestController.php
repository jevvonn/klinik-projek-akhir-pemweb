<?php

namespace App\Http\Controllers;

use App\Models\GudangRequest;
use App\Models\GudangRequestItem;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GudangRequestController extends Controller
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
        $title = 'Request dari Farmasi';
        $requests = GudangRequest::with(['items.obat'])
            ->latest()
            ->paginate(10);

        return view('dashboard.gudang.requests.index', compact('title', 'requests'));
    }

    public function show(GudangRequest $gudangRequest)
    {
        $this->checkGudangAccess();
        $title = 'Detail Request';

        // Refresh to get latest data from database
        $gudangRequest->refresh();
        $gudangRequest->load(['items.obat']);

        return view('dashboard.gudang.requests.show', compact('title', 'gudangRequest'));
    }
    public function approve(GudangRequest $gudangRequest)
    {
        $this->checkGudangAccess();
        if ($gudangRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Request sudah diproses sebelumnya.');
        }

        $gudangRequest->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Request berhasil disetujui.');
    }

    public function reject(Request $request, GudangRequest $gudangRequest)
    {
        $this->checkGudangAccess();
        if ($gudangRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Request sudah diproses sebelumnya.');
        }

        $validated = $request->validate([
            'catatan' => 'nullable|string',
        ]);

        $gudangRequest->update([
            'status' => 'rejected',
            'catatan' => $validated['catatan'] ?? 'Request ditolak oleh gudang.'
        ]);

        return redirect()->back()->with('success', 'Request berhasil ditolak.');
    }

    public function fulfill(Request $request, GudangRequest $gudangRequest)
    {
        $this->checkGudangAccess();

        // Refresh model to get latest data
        $gudangRequest->refresh();

        if ($gudangRequest->status !== 'approved') {
            return redirect()->back()->with('error', 'Request harus di-approve terlebih dahulu.');
        }
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.qty_dikirim' => 'required|integer|min:0',
        ]);

        try {
            DB::transaction(function () use ($gudangRequest, $validated) {
                foreach ($validated['items'] as $itemId => $data) {
                    $requestItem = GudangRequestItem::findOrFail($itemId);
                    $qtyDikirim = $data['qty_dikirim'];

                    if ($qtyDikirim > 0) {
                        // Update qty dikirim di request item
                        $requestItem->update(['qty_dikirim' => $qtyDikirim]);

                        // Kurangi stok gudang
                        $obat = $requestItem->obat;
                        $obat->updateStokGudang(
                            $qtyDikirim,
                            'send_to_farmasi',
                            "Mengirim obat ke farmasi - Request: {$gudangRequest->kode}",
                            $gudangRequest->kode
                        );

                        // Tambah stok farmasi
                        $stokFarmasi = $obat->stokFarmasi;
                        if ($stokFarmasi) {
                            $stokFarmasi->increment('jumlah', $qtyDikirim);

                            // PERBAIKAN: Sinkronisasi dengan kolom jumlah di tabel obat
                            $obat->increment('jumlah', $qtyDikirim);
                        } else {
                            // Jika belum ada record stok farmasi, buat yang baru
                            \App\Models\StokFarmasi::create([
                                'obat_id' => $obat->id,
                                'jumlah' => $qtyDikirim,
                                'stok_minimum' => 10
                            ]);

                            // Sinkronisasi dengan tabel obat
                            $obat->update(['jumlah' => $qtyDikirim]);
                        }
                    }
                }

                // Update status request
                $gudangRequest->update(['status' => 'fulfilled']);
            });

            return redirect()->back()->with('success', 'Obat berhasil dikirim ke farmasi.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Method untuk farmasi membuat request ke gudang
    public static function createFromFarmasi($obatId, $qty, $catatan = null, $requestedBy = 'farmasi')
    {
        $kode = GudangRequest::generateKode();

        $request = GudangRequest::create([
            'kode' => $kode,
            'status' => 'pending',
            'catatan' => $catatan ?? 'Auto request dari farmasi karena stok menipis',
            'requested_by' => $requestedBy
        ]);

        GudangRequestItem::create([
            'request_id' => $request->id,
            'obat_id' => $obatId,
            'qty_diminta' => $qty,
            'qty_dikirim' => 0
        ]);

        return $request;
    }
}