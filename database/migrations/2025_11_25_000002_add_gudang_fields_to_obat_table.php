<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            $table->integer('stok_gudang')->default(0)->after('jumlah');
            $table->string('lokasi_rak')->nullable()->after('stok_gudang');
            $table->foreignId('supplier_id')->nullable()->after('lokasi_rak')
                ->constrained('suppliers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->dropColumn(['stok_gudang', 'lokasi_rak', 'supplier_id']);
        });
    }
};