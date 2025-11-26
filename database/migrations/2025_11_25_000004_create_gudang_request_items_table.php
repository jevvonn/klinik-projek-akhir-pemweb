<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gudang_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')
                ->constrained('gudang_requests')
                ->cascadeOnDelete();
            $table->foreignId('obat_id')
                ->constrained('obat')
                ->cascadeOnDelete();
            $table->integer('qty_diminta');
            $table->integer('qty_dikirim')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gudang_request_items');
    }
};