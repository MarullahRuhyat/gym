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
        Schema::create('gaji_personal_trainers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_trainer_id')->constrained('users');
            $table->integer('salary');
            $table->date('bulan_gaji');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_personal_trainers');
    }
};
