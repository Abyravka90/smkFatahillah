<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['kesiswaans', 'kurikulums', 'hubungan_industris', 'keislamans', 'sarana_prasaranas', 'pramukas'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->text('profile_photo')->nullable()->after('image');
            });
        }
    }

    public function down(): void
    {
        foreach (['kesiswaans', 'kurikulums', 'hubungan_industris', 'keislamans', 'sarana_prasaranas', 'pramukas'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('profile_photo');
            });
        }
    }
};
