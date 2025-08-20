<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\Group;
use App\Models\TournamentMatch;
use Inertia\Inertia;

class TournamentController extends Controller
{
    /**
     * Display the tournament overview.
     */
    public function index()
    {
        $tournament = Tournament::with([
            'groups.groupTeams.team',
            'matches.homeTeam',
            'matches.awayTeam'
        ])->first();

        if (!$tournament) {
            return Inertia::render('welcome', [
                'tournament' => null,
                'groups' => [],
                'upcomingMatches' => [],
                'playoffMatches' => []
            ]);
        }

        // Get group stage tables
        $groups = $tournament->groups()->with(['groupTeams' => function($query) {
            $query->orderBy('points', 'desc')
                  ->orderBy('goal_difference', 'desc')
                  ->orderBy('goals_for', 'desc');
        }, 'groupTeams.team'])->get();

        // Get upcoming matches
        $upcomingMatches = $tournament->matches()
            ->with(['homeTeam', 'awayTeam', 'group'])
            ->where('status', 'scheduled')
            ->where('match_date', '>=', now())
            ->orderBy('match_date')
            ->limit(10)
            ->get();

        // Get playoff matches
        $playoffMatches = $tournament->matches()
            ->with(['homeTeam', 'awayTeam'])
            ->whereIn('stage', ['quarterfinals', 'semifinals', 'final'])
            ->orderBy('match_date')
            ->get();

        return Inertia::render('welcome', [
            'tournament' => $tournament,
            'groups' => $groups,
            'upcomingMatches' => $upcomingMatches,
            'playoffMatches' => $playoffMatches
        ]);
    }
}