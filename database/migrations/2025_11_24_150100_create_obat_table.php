<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('obat', function (Blueprint $table) {
            $table->id(); // id big integer auto increment
            $table->string('kode_obat', 50)->unique();
            $table->string('nama_obat', 150);
            $table->string('bentuk', 50)->nullable();
            $table->integer('jumlah')->default(0);
            $table->string('kategori', 100)->nullable();
            $table->decimal('harga_jual', 12, 2)->default(0);
            $table->boolean('status_aktif')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};
