<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GroupTeam>
 */
class GroupTeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $wins = $this->faker->numberBetween(0, 6);
        $draws = $this->faker->numberBetween(0, 6 - $wins);
        $losses = $this->faker->numberBetween(0, 6 - $wins - $draws);
        $matchesPlayed = $wins + $draws + $losses;
        $points = ($wins * 3) + $draws;
        $goalsFor = $this->faker->numberBetween($wins, $wins * 3 + $draws + $losses);
        $goalsAgainst = $this->faker->numberBetween($losses, $losses * 2 + $draws + $wins);

        return [
            'group_id' => Group::factory(),
            'team_id' => Team::factory(),
            'points' => $points,
            'matches_played' => $matchesPlayed,
            'wins' => $wins,
            'draws' => $draws,
            'losses' => $losses,
            'goals_for' => $goalsFor,
            'goals_against' => $goalsAgainst,
            'goal_difference' => $goalsFor - $goalsAgainst,
        ];
    }
}