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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tournament name');
            $table->text('description')->nullable()->comment('Tournament description');
            $table->date('start_date')->comment('Tournament start date');
            $table->date('end_date')->comment('Tournament end date');
            $table->enum('status', ['upcoming', 'group_stage', 'playoffs', 'completed'])->default('upcoming')->comment('Tournament status');
            $table->timestamps();
            
            $table->index('status');
            $table->index('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};