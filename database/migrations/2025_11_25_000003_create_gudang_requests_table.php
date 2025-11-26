<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gudang_requests', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->enum('status', ['pending', 'approved', 'rejected', 'fulfilled'])
                ->default('pending');
            $table->text('catatan')->nullable();
            $table->string('requested_by')->default('farmasi'); // farmasi, manual, auto_system
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gudang_requests');
    }
};