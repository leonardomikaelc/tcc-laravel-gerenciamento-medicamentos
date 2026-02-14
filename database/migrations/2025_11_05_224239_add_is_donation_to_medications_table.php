<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->boolean('is_donation')->default(0);
        });
    }

    public function down()
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->dropColumn('is_donation');
        });
    }
};
