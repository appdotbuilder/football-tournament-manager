<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teams = [
            ['name' => 'Arsenal FC', 'code' => 'ARS'],
            ['name' => 'Manchester United', 'code' => 'MUN'],
            ['name' => 'Liverpool FC', 'code' => 'LIV'],
            ['name' => 'Chelsea FC', 'code' => 'CHE'],
            ['name' => 'Manchester City', 'code' => 'MCI'],
            ['name' => 'Tottenham Hotspur', 'code' => 'TOT'],
            ['name' => 'Newcastle United', 'code' => 'NEW'],
            ['name' => 'Brighton & Hove Albion', 'code' => 'BRI'],
            ['name' => 'West Ham United', 'code' => 'WHU'],
            ['name' => 'Aston Villa', 'code' => 'AVL'],
            ['name' => 'Crystal Palace', 'code' => 'CRY'],
            ['name' => 'Fulham FC', 'code' => 'FUL'],
            ['name' => 'Wolverhampton Wanderers', 'code' => 'WOL'],
            ['name' => 'Everton FC', 'code' => 'EVE'],
            ['name' => 'Brentford FC', 'code' => 'BRE'],
            ['name' => 'Nottingham Forest', 'code' => 'NFO'],
        ];

        $team = $this->faker->randomElement($teams);

        return [
            'name' => $team['name'],
            'code' => $team['code'],
            'description' => $this->faker->paragraph(),
        ];
    }
}