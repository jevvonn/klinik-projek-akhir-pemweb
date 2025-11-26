<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gudang_requests', function (Blueprint $table) {
            $table->enum('jenis_request', ['manual', 'auto_system'])->default('manual')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gudang_requests', function (Blueprint $table) {
            $table->dropColumn('jenis_request');
        });
    }
};
