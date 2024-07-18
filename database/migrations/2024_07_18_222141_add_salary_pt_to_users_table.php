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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('salary_pt')->nullable();
    
            // Jika Anda ingin menambahkan foreign key constraint
            $table->foreign('salary_pt')->references('id')->on('gaji_personal_trainers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['salary_pt']);
            $table->dropColumn('salary_pt');
        });
    }
};
