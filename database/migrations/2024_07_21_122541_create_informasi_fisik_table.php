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
        Schema::create('informasi_fisik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->float('berat_badan')->nullable();
            $table->float('tinggi_badan')->nullable();
            $table->float('massa_tulang')->nullable();
            $table->float('massa_otot')->nullable();
            $table->float('persentase_lemak_tubuh')->nullable();
            $table->string('intoleransi_latihan_atau_alergi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_fisik');
    }
};
