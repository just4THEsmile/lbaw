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
        Schema::create('badge_attainments', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('badge_id');
            $table->timestamp('date')->nullable();
            
            // Define foreign keys and other constraints here
            
            $table->primary(['user_id', 'badge_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badge_attainments');
    }
};
