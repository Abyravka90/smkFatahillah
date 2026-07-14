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
        Schema::table('mikrotiks', function (Blueprint $table) {
            $table->string('sertifikat_trainer')->nullable()->after('tentang_mikrotik_academy');
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
    {
        Schema::table('mikrotiks', function (Blueprint $table) {
            $table->dropColumn('sertifikat_trainer');
        });
    }
};
