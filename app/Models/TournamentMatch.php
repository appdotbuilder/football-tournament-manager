<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TournamentMatch
 *
 * @property int $id
 * @property int $tournament_id
 * @property int|null $group_id
 * @property int $home_team_id
 * @property int $away_team_id
 * @property \Illuminate\Support\Carbon $match_date
 * @property string $venue
 * @property string|null $referee
 * @property int|null $home_score
 * @property int|null $away_score
 * @property string $status
 * @property string $stage
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tournament $tournament
 * @property-read \App\Models\Group|null $group
 * @property-read \App\Models\Team $homeTeam
 * @property-read \App\Models\Team $awayTeam
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch query()
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch whereAwayScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch whereAwayTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch whereHomeScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch whereHomeTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch whereMatchDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch whereReferee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch whereStage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch whereTournamentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentMatch whereVenue($value)
 * @method static \Database\Factories\TournamentMatchFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class TournamentMatch extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'matches';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tournament_id',
        'group_id',
        'home_team_id',
        'away_team_id',
        'match_date',
        'venue',
        'referee',
        'home_score',
        'away_score',
        'status',
        'stage',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'match_date' => 'datetime',
        'home_score' => 'integer',
        'away_score' => 'integer',
    ];

    /**
     * Get the tournament this match belongs to.
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * Get the group this match belongs to.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the home team.
     */
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    /**
     * Get the away team.
     */
    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
}