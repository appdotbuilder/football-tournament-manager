<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tournament>
 */
class TournamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+1 month');
        $endDate = (clone $startDate)->modify('+2 months');

        return [
            'name' => 'Premier League Cup 2024',
            'description' => 'Annual football tournament featuring the best teams in the league.',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'group_stage',
        ];
    }
}