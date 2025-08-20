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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->foreignId('group_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('home_team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('away_team_id')->constrained('teams')->cascadeOnDelete();
            $table->datetime('match_date')->comment('Match date and time');
            $table->string('venue')->comment('Match venue');
            $table->string('referee')->nullable()->comment('Referee name');
            $table->integer('home_score')->nullable()->comment('Home team score');
            $table->integer('away_score')->nullable()->comment('Away team score');
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'postponed'])->default('scheduled')->comment('Match status');
            $table->enum('stage', ['group_stage_1', 'group_stage_2', 'quarterfinals', 'semifinals', 'final'])->comment('Match stage');
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->timestamps();
            
            $table->index('match_date');
            $table->index(['tournament_id', 'status']);
            $table->index(['group_id', 'stage']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};