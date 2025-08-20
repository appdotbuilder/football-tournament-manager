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
        Schema::create('group_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->integer('points')->default(0)->comment('Total points earned');
            $table->integer('matches_played')->default(0)->comment('Number of matches played');
            $table->integer('wins')->default(0)->comment('Number of wins');
            $table->integer('draws')->default(0)->comment('Number of draws');
            $table->integer('losses')->default(0)->comment('Number of losses');
            $table->integer('goals_for')->default(0)->comment('Goals scored');
            $table->integer('goals_against')->default(0)->comment('Goals conceded');
            $table->integer('goal_difference')->default(0)->comment('Goal difference');
            $table->timestamps();
            
            $table->unique(['group_id', 'team_id']);
            $table->index(['group_id', 'points']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_teams');
    }
};