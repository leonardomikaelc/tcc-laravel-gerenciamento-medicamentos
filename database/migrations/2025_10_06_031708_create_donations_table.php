<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();


            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('medication_id')->constrained('medications')->onDelete('cascade');


            $table->date('donation_date')->default(DB::raw('CURRENT_DATE'));


            $table->enum('status', ['available', 'delivered', 'cancelled'])->default('available');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
