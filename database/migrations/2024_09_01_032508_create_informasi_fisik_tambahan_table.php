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
        Schema::create('informasi_fisik_tambahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->float('leher')->nullable();
            $table->float('bahu')->nullable();
            $table->float('dada')->nullable();
            $table->float('lengan_kanan')->nullable();
            $table->float('lengan_kiri')->nullable();
            $table->float('fore_arm_kanan')->nullable();
            $table->float('fore_arm_kiri')->nullable();
            $table->float('perut')->nullable();
            $table->float('pinggang')->nullable();
            $table->float('paha_kanan')->nullable();
            $table->float('paha_kiri')->nullable();
            $table->float('betis_kanan')->nullable();
            $table->float('betis_kiri')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_fisik_tambahan');
    }
};
