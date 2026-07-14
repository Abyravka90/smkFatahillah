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
        Schema::create('mikrotiks', function (Blueprint $table) {
            $table->id();
            $table->text('trainer')->nullable();
            $table->longText('materi')->nullable();
            $table->string('foto_kegiatan_1')->nullable();
            $table->string('foto_kegiatan_2')->nullable();
            $table->string('foto_kegiatan_3')->nullable();
            $table->string('sertifikat_1')->nullable();
            $table->string('sertifikat_2')->nullable();
            $table->string('sertifikat_3')->nullable();
            $table->text('tentang_mikrotik_academy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mikrotiks');
    }
};
