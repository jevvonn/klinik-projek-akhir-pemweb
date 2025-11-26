<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
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
        $title = 'Data Supplier';
        $suppliers = Supplier::with('obat')->latest()->get();
        return view('dashboard.suppliers.index', compact('title', 'suppliers'));
    }

    public function create()
    {
        $this->checkGudangAccess();
        $title = 'Tambah Supplier';
        return view('dashboard.suppliers.create', compact('title'));
    }

    public function store(Request $request)
    {
        $this->checkGudangAccess();
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email',
            'telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        Supplier::create($validated);

        return redirect()->route('dashboard.suppliers.index')
            ->with('ok', 'Supplier berhasil ditambahkan.');
    }

    public function show(Supplier $supplier)
    {
        $this->checkGudangAccess();
        $title = 'Detail Supplier';
        $supplier->load('obat');
        return view('dashboard.gudang.supplier.show', compact('title', 'supplier'));
    }

    public function edit(Supplier $supplier)
    {
        $this->checkGudangAccess();
        $title = 'Edit Supplier';
        return view('dashboard.suppliers.edit', compact('title', 'supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $this->checkGudangAccess();
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email,' . $supplier->id,
            'telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $supplier->update($validated);

        return redirect()->route('dashboard.suppliers.index')
            ->with('ok', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $this->checkGudangAccess();
        // Check if supplier has related obat
        if ($supplier->obat()->count() > 0) {
            return redirect()->route('dashboard.suppliers.index')
                ->with('error', 'Supplier tidak dapat dihapus karena masih memiliki obat terkait.');
        }

        $supplier->delete();

        return redirect()->route('dashboard.suppliers.index')
            ->with('ok', 'Supplier berhasil dihapus.');
    }
}