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
        Schema::create('absent_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('users');
            $table->foreignId('personal_trainer_id')->nullable()->constrained('users');
            $table->time('start_time')->nullable();;
            $table->time('end_time')->nullable();;
            $table->date('date')->nullable();
            $table->string('qr_code');
            $table->string('path_qr_code');
            $table->string('jenis_latihan')->nullable();
            // $table->foreignId('jenis_latihan')->nullable()->constrained('jenis_latihans');
            $table->boolean('is_using_pt')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absent_members');
    }
};
