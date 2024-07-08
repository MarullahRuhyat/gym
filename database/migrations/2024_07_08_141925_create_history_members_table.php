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
        Schema::create('history_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('gym_membership_packages');
            $table->foreignId('user_id')->constrained('users');
            $table->float('is_active')->default(1);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('number_of_days_available_for_use');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_members');
    }
};
