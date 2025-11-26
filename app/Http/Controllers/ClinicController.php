<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClinicRequest;

class ClinicController extends Controller
{
    public function index()
    {
        $requests = ClinicRequest::latest()->get();

        return view('dashboard.klinik.index', [
            'title' => 'Monitoring Pasien',
            'requests' => $requests
        ]);
    }

    public function createShow()
    {
        return view('dashboard.klinik.form-klinik', [
            'title' => 'Detail Permintaan Klinik',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required',
            'no_hp'  => 'required',
            'umur'   => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'diagnosa' => 'required',
            'dokter' => 'required',
            'resep_obat'  => 'required',
        ]);

        ClinicRequest::create([
            'nama'    => $request->nama,
            'umur' => $request->umur,
            'no_hp'   => $request->no_hp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'  => $request->alamat,
            'diagnosa' => $request->diagnosa,
            'dokter'  => $request->dokter,
            'resep_obat' => $request->resep_obat,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard-klinik')
            ->with('success', 'Request resep berhasil disimpan!');
    }

    public function show($id)
    {
        $request = ClinicRequest::findOrFail($id);

        return view('dashboard.klinik.detail', [
            'title' => 'Detail Permintaan Klinik',
            'data' => $request
        ]);
    }
}
