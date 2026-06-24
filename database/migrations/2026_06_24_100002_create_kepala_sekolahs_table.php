<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kepala_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('content');
            $table->text('image')->nullable();
            $table->text('profile_photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kepala_sekolahs');
    }
};
