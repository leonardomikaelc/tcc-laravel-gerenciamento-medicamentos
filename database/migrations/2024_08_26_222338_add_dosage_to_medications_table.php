<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDosageToMedicationsTable extends Migration
{
    public function up()
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->string('dosage')->nullable(); // Adiciona a coluna dosage
        });
    }

    public function down()
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->dropColumn('dosage'); // Remove a coluna caso seja necessário reverter
        });
    }
}
