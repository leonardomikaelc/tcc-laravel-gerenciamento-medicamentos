<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDonationFieldsToMedicationsTable extends Migration
{
    public function up()
    {
        Schema::table('medications', function (Blueprint $table) {


            if (!Schema::hasColumn('medications', 'disponivel_para_doacao')) {
                $table->boolean('disponivel_para_doacao')->default(false)->after('controlled');
            }

            if (!Schema::hasColumn('medications', 'data_doacao')) {
                $table->date('data_doacao')->nullable()->after('disponivel_para_doacao');
            }

            if (!Schema::hasColumn('medications', 'destino_doacao')) {
                $table->string('destino_doacao', 255)->nullable()->after('data_doacao');
            }
        });
    }

    public function down()
    {
        Schema::table('medications', function (Blueprint $table) {
            if (Schema::hasColumn('medications', 'disponivel_para_doacao')) {
                $table->dropColumn('disponivel_para_doacao');
            }
            if (Schema::hasColumn('medications', 'data_doacao')) {
                $table->dropColumn('data_doacao');
            }
            if (Schema::hasColumn('medications', 'destino_doacao')) {
                $table->dropColumn('destino_doacao');
            }
        });
    }
}
