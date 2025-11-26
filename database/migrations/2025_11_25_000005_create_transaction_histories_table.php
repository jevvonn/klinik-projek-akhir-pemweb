<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaction_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_id')->constrained('obat')->cascadeOnDelete();
            $table->enum('aksi', [
                'receive_from_supplier', // barang masuk gudang dari supplier
                'send_to_farmasi',       // barang keluar ke farmasi
                'request_from_farmasi',  // farmasi buat request ke gudang
                'manual_adjustment'      // penyesuaian manual stok
            ]);
            $table->integer('qty');
            $table->integer('stok_sebelum')->nullable();
            $table->integer('stok_sesudah')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('reference_code')->nullable(); // kode request/transaksi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_histories');
    }
};