<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMatchRequest;
use App\Http\Requests\UpdateMatchRequest;
use App\Models\TournamentMatch;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\Group;
use Inertia\Inertia;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matches = TournamentMatch::with(['homeTeam', 'awayTeam', 'group'])
            ->latest('match_date')
            ->paginate(10);
        
        return Inertia::render('matches/index', [
            'matches' => $matches
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = Team::all();
        $tournaments = Tournament::all();
        $groups = Group::with('tournament')->get();
        
        return Inertia::render('matches/create', [
            'teams' => $teams,
            'tournaments' => $tournaments,
            'groups' => $groups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatchRequest $request)
    {
        TournamentMatch::create($request->validated());

        return redirect()->route('matches.index')
            ->with('success', 'Match created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TournamentMatch $tournamentMatch)
    {
        $tournamentMatch->load(['homeTeam', 'awayTeam', 'group', 'tournament']);
        
        return Inertia::render('matches/show', [
            'match' => $tournamentMatch
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TournamentMatch $tournamentMatch)
    {
        $tournamentMatch->load(['homeTeam', 'awayTeam', 'group', 'tournament']);
        $teams = Team::all();
        
        return Inertia::render('matches/edit', [
            'match' => $tournamentMatch,
            'teams' => $teams
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMatchRequest $request, TournamentMatch $tournamentMatch)
    {
        $tournamentMatch->update($request->validated());

        return redirect()->route('matches.index')
            ->with('success', 'Match updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TournamentMatch $tournamentMatch)
    {
        $tournamentMatch->delete();

        return redirect()->route('matches.index')
            ->with('success', 'Match deleted successfully.');
    }
}