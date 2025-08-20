<?php

namespace Database\Seeders;

use App\Models\Tournament;
use App\Models\Team;
use App\Models\Group;
use App\Models\GroupTeam;
use App\Models\TournamentMatch;
use Illuminate\Database\Seeder;

class TournamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create tournament
        $tournament = Tournament::create([
            'name' => 'Premier League Cup 2024',
            'description' => 'Annual football tournament featuring the best teams in the league.',
            'start_date' => now()->subWeeks(2),
            'end_date' => now()->addMonths(2),
            'status' => 'group_stage',
        ]);

        // Create teams
        $teamData = [
            ['name' => 'Arsenal FC', 'code' => 'ARS'],
            ['name' => 'Manchester United', 'code' => 'MUN'],
            ['name' => 'Liverpool FC', 'code' => 'LIV'],
            ['name' => 'Chelsea FC', 'code' => 'CHE'],
            ['name' => 'Manchester City', 'code' => 'MCI'],
            ['name' => 'Tottenham Hotspur', 'code' => 'TOT'],
            ['name' => 'Newcastle United', 'code' => 'NEW'],
            ['name' => 'Brighton & Hove Albion', 'code' => 'BRI'],
        ];

        $teams = collect($teamData)->map(function ($data) {
            return Team::create([
                'name' => $data['name'],
                'code' => $data['code'],
                'description' => 'Professional football team competing in the Premier League Cup.',
            ]);
        });

        // Create groups for stage 1
        $groupA = Group::create([
            'tournament_id' => $tournament->id,
            'name' => 'Group A',
            'stage' => 1,
        ]);

        $groupB = Group::create([
            'tournament_id' => $tournament->id,
            'name' => 'Group B',
            'stage' => 1,
        ]);

        // Assign teams to groups (4 teams each)
        $groupATeams = $teams->take(4);
        $groupBTeams = $teams->skip(4);

        foreach ($groupATeams as $team) {
            GroupTeam::create([
                'group_id' => $groupA->id,
                'team_id' => $team->id,
                'points' => random_int(3, 15),
                'matches_played' => random_int(2, 6),
                'wins' => random_int(1, 5),
                'draws' => random_int(0, 2),
                'losses' => random_int(0, 3),
                'goals_for' => random_int(2, 12),
                'goals_against' => random_int(1, 8),
                'goal_difference' => random_int(-3, 8),
            ]);
        }

        foreach ($groupBTeams as $team) {
            GroupTeam::create([
                'group_id' => $groupB->id,
                'team_id' => $team->id,
                'points' => random_int(3, 15),
                'matches_played' => random_int(2, 6),
                'wins' => random_int(1, 5),
                'draws' => random_int(0, 2),
                'losses' => random_int(0, 3),
                'goals_for' => random_int(2, 12),
                'goals_against' => random_int(1, 8),
                'goal_difference' => random_int(-3, 8),
            ]);
        }

        // Create some matches
        $venues = [
            'Wembley Stadium',
            'Old Trafford', 
            'Emirates Stadium',
            'Anfield',
            'Stamford Bridge',
            'Etihad Stadium',
        ];

        // Group stage matches
        foreach ([$groupA, $groupB] as $group) {
            /** @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupTeam> $groupTeams */
            $groupTeams = $group->groupTeams()->with('team')->get();
            
            for ($i = 0; $i < 3; $i++) {
                /** @var \App\Models\GroupTeam $homeTeam */
                $homeTeam = $groupTeams->random();
                /** @var \App\Models\GroupTeam $awayTeam */
                $awayTeam = $groupTeams->where('id', '!=', $homeTeam->id)->random();
                
                TournamentMatch::create([
                    'tournament_id' => $tournament->id,
                    'group_id' => $group->id,
                    'home_team_id' => $homeTeam->team->id,
                    'away_team_id' => $awayTeam->team->id,
                    'match_date' => now()->addDays(random_int(1, 30))->addHours(random_int(10, 20)),
                    'venue' => $venues[array_rand($venues)],
                    'referee' => 'Referee ' . random_int(1, 10),
                    'status' => 'scheduled',
                    'stage' => 'group_stage_1',
                ]);
            }
        }

        // Create some playoff matches
        $playoffTeams = $teams->random(4);
        
        TournamentMatch::create([
            'tournament_id' => $tournament->id,
            'home_team_id' => $playoffTeams[0]->id,
            'away_team_id' => $playoffTeams[1]->id,
            'match_date' => now()->addMonth()->addDays(5),
            'venue' => 'Wembley Stadium',
            'referee' => 'Final Referee',
            'status' => 'scheduled',
            'stage' => 'final',
        ]);
    }
}