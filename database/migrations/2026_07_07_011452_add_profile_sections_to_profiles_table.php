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
        Schema::table('profiles', function (Blueprint $table) {
            $table->text('sejarah_content')->nullable();
            $table->string('struktur_organisasi_image')->nullable();
            $table->text('visi_misi_content')->nullable();
            $table->text('hymne_fatahillah_content')->nullable();
            $table->text('mars_fatahillah_content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'sejarah_content',
                'struktur_organisasi_image',
                'visi_misi_content',
                'hymne_fatahillah_content',
                'mars_fatahillah_content',
            ]);
        });
    }
};
