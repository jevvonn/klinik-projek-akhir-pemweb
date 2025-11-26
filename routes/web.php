<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ValidasiResepFarmasiController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\GudangRequestController;
use App\Http\Controllers\StokFarmasiController;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    // Debug: Log untuk melihat apa yang terjadi
    Log::info('Root route accessed');
    return redirect()->route('login');
});

// Middleware Guest (Untuk yang belum login)
Route::middleware(['guest'])->group(function () {
    Route::get("/login", [AuthController::class, "loginPage"])->name("login");
    Route::post("/login", [AuthController::class, "login"]);
});

// Middleware Auth (Hanya yang sudah login)
Route::middleware(['auth'])->group(function () {

    // Grouping URL "/dashboard"
    Route::prefix('dashboard')->group(function () {

        // Halaman Utama Dashboard (index)
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/klinik', [ClinicController::class, 'index'])->name('dashboard-klinik');

        // tambah route untuk nambah pasien dibawah ini nanti...
        Route::get('/klinik/tambah-pasien', [ClinicController::class, 'createShow'])->name('dashboard-klinik-tambah-pasien');
        Route::get('/klinik/detail-pasien/{id}', [ClinicController::class, 'show'])->name('dashboard-klinik-detail-pasien');

        // --- FARMASI ---
        Route::prefix('farmasi')->group(function () {

            // halaman utama farmasi (stok)
            Route::get('/', [StokFarmasiController::class, 'index'])->name('dashboard-farmasi');

            // stok obat
            Route::get('/edit-stokObat/{kode_obat}', [StokFarmasiController::class, 'edit'])
                ->name('farmasi.stok.edit');
            Route::put('/{obat}', [StokFarmasiController::class, 'update'])
                ->name('farmasi.stok.update');

            // CRUD OBAT -> URL /dashboard/farmasi/obat/...
            Route::resource('obat', ObatController::class)->names('obat');
            // hasilnya:
            // GET  /dashboard/farmasi/obat           -> obat.index
            // GET  /dashboard/farmasi/obat/create    -> obat.create
            // POST /dashboard/farmasi/obat           -> obat.store
            // GET  /dashboard/farmasi/obat/{obat}    -> obat.show
            // GET  /dashboard/farmasi/obat/{obat}/edit -> obat.edit
            // PUT  /dashboard/farmasi/obat/{obat}    -> obat.update
            // DELETE /dashboard/farmasi/obat/{obat}  -> obat.destroy

            // VALIDASI RESEP PASIEN
            Route::get('/validasi-resep', [ValidasiResepFarmasiController::class, 'index'])
                ->name('farmasi.validasi.index');

            Route::post('/validasi-resep/{id}/complete', [ValidasiResepFarmasiController::class, 'markCompleted'])
                ->name('farmasi.validasi.complete');

            // Form & proses validasi obat
            Route::get('/validasi-resep/pasien/{id}', [ValidasiResepFarmasiController::class, 'showFormObat'])
                ->name('farmasi.validasi.obat.form');

            Route::post('/validasi-resep/pasien/{id}', [ValidasiResepFarmasiController::class, 'validateObat'])
                ->name('farmasi.validasi.obat.process');
        });

        // --- GUDANG ---
        Route::prefix('gudang')->group(function () {

            // halaman utama gudang (stok)
            Route::get('/', [GudangController::class, 'index'])->name('dashboard.gudang.index');

            // penerimaan dari supplier
            Route::post('/receive', [GudangController::class, 'receiveFromSupplier'])
                ->name('gudang.stok.receive');

            // riwayat transaksi
            Route::get('/history', [GudangController::class, 'history'])
                ->name('gudang.history');

            // CRUD OBAT untuk GUDANG -> URL /dashboard/gudang/obat/...
            Route::prefix('obat')->name('dashboard.gudang.obat.')->group(function () {
                Route::get('/', [GudangController::class, 'obatIndex'])->name('index');
                Route::get('/create', [GudangController::class, 'obatCreate'])->name('create');
                Route::post('/', [GudangController::class, 'obatStore'])->name('store');
                Route::get('/{obat}/edit', [GudangController::class, 'obatEdit'])->name('edit');
                Route::put('/{obat}', [GudangController::class, 'obatUpdate'])->name('update');
                Route::delete('/{obat}', [GudangController::class, 'obatDestroy'])->name('destroy');
            });

            // REQUEST MANAGEMENT
            Route::prefix('requests')->name('dashboard.gudang.requests.')->group(function () {
                Route::get('/', [GudangRequestController::class, 'index'])->name('index');
                Route::get('/{gudangRequest}', [GudangRequestController::class, 'show'])->name('show');
                Route::post('/{gudangRequest}/approve', [GudangRequestController::class, 'approve'])->name('approve');
                Route::post('/{gudangRequest}/reject', [GudangRequestController::class, 'reject'])->name('reject');
                Route::post('/{gudangRequest}/fulfill', [GudangRequestController::class, 'fulfill'])->name('fulfill');
            });
        });

        // --- SUPPLIERS ---
        Route::prefix('suppliers')->name('dashboard.suppliers.')->group(function () {
            Route::get('/', [SupplierController::class, 'index'])->name('index');
            Route::get('/create', [SupplierController::class, 'create'])->name('create');
            Route::post('/', [SupplierController::class, 'store'])->name('store');
            Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('edit');
            Route::put('/{supplier}', [SupplierController::class, 'update'])->name('update');
            Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('destroy');
        });
    });

    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::fallback(function () {
    return response()->view('not-found', [], 404);
});

Route::post('/klinik/request/store', [ClinicController::class, 'store'])
    ->name('klinik.request.store');
