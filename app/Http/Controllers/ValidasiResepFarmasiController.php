<?php

namespace App\Http\Controllers;

use App\Models\ClinicRequest;
use App\Models\Obat;
use App\Models\StokFarmasi;
use App\Http\Controllers\GudangRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidasiResepFarmasiController extends Controller
{
    // List semua request resep dari Klinik
    public function index()
    {
        $title = 'Validasi Resep Pasien';

        // Kalau mau semua:
        $requests = ClinicRequest::orderByDesc('created_at')->paginate(10);

        // Kalau mau hanya pending:
        // $requests = ClinicRequest::where('status', 'pending')->latest()->paginate(10);

        return view('dashboard.farmasi.validasi.index', compact('title', 'requests'));
    }

    // Ubah status dari processed -> completed (selesai)
    public function markCompleted($id)
    {
        $req = ClinicRequest::findOrFail($id);

        // hanya boleh kalau sudah processed
        if ($req->status === 'processed') {
            $req->update(['status' => 'completed']);
        }

        return redirect()->route('farmasi.validasi.index')
            ->with('success', 'Resep pasien ditandai selesai.');
    }

    public function showFormObat($id)
    {

        $request = ClinicRequest::findOrFail($id);     // data pasien & resep teks
        $title = 'Validasi Obat untuk Pasien';
        $obats = Obat::with('stokFarmasi')->orderBy('nama_obat')->get();  // semua obat di farmasi

        return view('dashboard.farmasi.validasi.form-obat', compact('title', 'request', 'obats'));
    }

    public function validateObat(Request $request, $id)
    {
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'qty' => 'required|integer|min:1',
        ]);

        try {

            DB::transaction(function () use ($request, $id) {

                $clinicRequest = ClinicRequest::findOrFail($id);
                $obat = Obat::findOrFail($request->obat_id);
                $qtyRequest = (int) $request->qty;

                // --- ambil / inisialisasi stok farmasi ---
                // pakai firstOrNew supaya tidak langsung set qty=0 ke DB
                $stok = StokFarmasi::firstOrNew(['obat_id' => $obat->id]);

                // kalau belum ada record stok_farmasi -> anggap stok awal = jumlah di tabel obat
                if (is_null($stok->jumlah)) {
                    $stok->jumlah = $obat->jumlah ?? 0;
                }

                $available = (int) $stok->jumlah;

                // CEK stok cukup
                if ($available <= 0 || $available < $qtyRequest) {
                    throw new \RuntimeException(
                        'Stok ' . $obat->nama_obat . ' tidak mencukupi. Tersedia: ' . $available
                    );
                }

                // --- kurangi stok ---
                $stok->jumlah = $available - $qtyRequest;
                $stok->save();

                // sinkronkan ke kolom jumlah di tabel obat
                $obat->jumlah = max(0, ($obat->jumlah ?? 0) - $qtyRequest);
                $obat->save();

                // CEK APAKAH PERLU AUTO-REQUEST KE GUDANG
                $stokMinimum = $stok->stok_minimum ?? 10;
                if ($stok->jumlah <= $stokMinimum && $obat->stok_gudang > 0) {

                    // PERBAIKAN: Cek apakah sudah ada request pending/approved untuk obat ini
                    $existingRequest = \App\Models\GudangRequest::whereHas('items', function ($query) use ($obat) {
                        $query->where('obat_id', $obat->id);
                    })
                        ->whereIn('status', ['pending', 'approved']) // Cek pending DAN approved
                        ->where('requested_by', 'auto_system')
                        ->where('created_at', '>=', now()->subDay())
                        ->exists();

                    if (!$existingRequest) {
                        // Auto-create request ke gudang jika stok farmasi di bawah minimum
                        $qtyRequest = min($stokMinimum * 2, $obat->stok_gudang); // Request 2x stok minimum atau sesuai stok gudang

                        GudangRequestController::createFromFarmasi(
                            $obat->id,
                            $qtyRequest,
                            "Auto-request: Stok farmasi {$obat->nama_obat} di bawah minimum ({$stok->jumlah})"
                        );
                    }
                }

                // ubah status permintaan jadi completed (atau processed, terserah flow kamu)
                $clinicRequest->status = 'processed';
                $clinicRequest->save();
            });

            return redirect()->route('farmasi.validasi.index')
                ->with('success', 'Obat berhasil divalidasi dan stok farmasi telah dikurangi.');

        } catch (\RuntimeException $e) {
            // kalau stok tidak cukup, jangan 500, tapi kembali ke form dengan pesan error
            return back()
                ->withErrors(['qty' => $e->getMessage()])
                ->withInput();
        }
    }
}
