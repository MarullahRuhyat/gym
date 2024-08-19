<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::table('absent_members', function (Blueprint $table) {
    //             $table->unsignedBigInteger('id_paket_member'); // Menambahkan kolom id_paket_member setelah kolom id
    //             $table->foreign('id_paket_member')->references('id')->on('gym_membership_packages')->onDelete('cascade');
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::table('absent_members', function (Blueprint $table) {
    //         $table->dropForeign(['id_paket_member']);
    //         $table->dropColumn('id_paket_member');
    //     });
    // }
};
