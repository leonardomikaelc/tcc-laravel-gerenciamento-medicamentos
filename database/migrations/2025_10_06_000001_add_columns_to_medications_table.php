<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medications', function (Blueprint $table) {

            if (!Schema::hasColumn('medications', 'apresentacao')) {
                $table->enum('apresentacao', [
                    'comprimido',
                    'drágea',
                    'cápsula',
                    'gotas',
                    'xarope',
                    'ampola'
                ])->nullable();
            }


            if (!Schema::hasColumn('medications', 'disponivel_para_doacao')) {
                $table->boolean('disponivel_para_doacao')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->dropColumn(['apresentacao', 'disponivel_para_doacao']);
        });
    }
};
