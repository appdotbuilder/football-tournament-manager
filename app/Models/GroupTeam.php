<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\GroupTeam
 *
 * @property int $id
 * @property int $group_id
 * @property int $team_id
 * @property int $points
 * @property int $matches_played
 * @property int $wins
 * @property int $draws
 * @property int $losses
 * @property int $goals_for
 * @property int $goals_against
 * @property int $goal_difference
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Group $group
 * @property-read \App\Models\Team $team
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam query()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam whereDraws($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam whereGoalDifference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam whereGoalsAgainst($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam whereGoalsFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam whereLosses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam whereMatchesPlayed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTeam whereWins($value)
 * @method static \Database\Factories\GroupTeamFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class GroupTeam extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'group_id',
        'team_id',
        'points',
        'matches_played',
        'wins',
        'draws',
        'losses',
        'goals_for',
        'goals_against',
        'goal_difference',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'points' => 'integer',
        'matches_played' => 'integer',
        'wins' => 'integer',
        'draws' => 'integer',
        'losses' => 'integer',
        'goals_for' => 'integer',
        'goals_against' => 'integer',
        'goal_difference' => 'integer',
    ];

    /**
     * Get the group this record belongs to.
     *
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the team this record belongs to.
     *
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}