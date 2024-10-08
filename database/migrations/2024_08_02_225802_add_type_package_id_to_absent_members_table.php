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
        Schema::table('absent_members', function (Blueprint $table) {
            $table->foreignId('type_packages_id')->nullable()->constrained('type_packages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absent_members', function (Blueprint $table) {
            $table->dropForeign(['type_packages_id']);
            $table->dropColumn('type_packages_id');
        });
    }
};
