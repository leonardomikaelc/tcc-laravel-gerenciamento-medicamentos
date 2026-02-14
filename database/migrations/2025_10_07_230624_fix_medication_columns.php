<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            if (!Schema::hasColumn('medications', 'quantidade')) {
                $table->integer('quantidade')->after('expiration_date');
            }
            if (!Schema::hasColumn('medications', 'apresentacao')) {
                $table->enum('apresentacao', ['comprimido', 'drágea', 'cápsula', 'gotas', 'xarope', 'ampola'])
                      ->after('quantidade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->dropColumn(['quantidade', 'apresentacao']);
        });
    }
};
