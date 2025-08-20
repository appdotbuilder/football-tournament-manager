<?php

namespace Database\Factories;

use App\Models\Tournament;
use App\Models\Team;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TournamentMatch>
 */
class TournamentMatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $venues = [
            'Wembley Stadium',
            'Old Trafford',
            'Emirates Stadium',
            'Anfield',
            'Stamford Bridge',
            'Etihad Stadium',
            'Tottenham Hotspur Stadium',
            'London Stadium',
        ];

        return [
            'tournament_id' => Tournament::factory(),
            'group_id' => Group::factory(),
            'home_team_id' => Team::factory(),
            'away_team_id' => Team::factory(),
            'match_date' => $this->faker->dateTimeBetween('+1 week', '+2 months'),
            'venue' => $this->faker->randomElement($venues),
            'referee' => $this->faker->name(),
            'status' => $this->faker->randomElement(['scheduled', 'completed']),
            'stage' => 'group_stage_1',
        ];
    }

    /**
     * Indicate that the match is completed with scores.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'home_score' => $this->faker->numberBetween(0, 4),
            'away_score' => $this->faker->numberBetween(0, 4),
        ]);
    }
}