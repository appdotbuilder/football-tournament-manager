<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Group
 *
 * @property int $id
 * @property int $tournament_id
 * @property string $name
 * @property int $stage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tournament $tournament
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupTeam> $groupTeams
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TournamentMatch> $matches
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereStage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereTournamentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereUpdatedAt($value)
 * @method static \Database\Factories\GroupFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tournament_id',
        'name',
        'stage',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'stage' => 'integer',
    ];

    /**
     * Get the tournament this group belongs to.
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * Get all group team records for this group.
     */
    public function groupTeams(): HasMany
    {
        return $this->hasMany(GroupTeam::class);
    }

    /**
     * Get all matches for this group.
     */
    public function matches(): HasMany
    {
        return $this->hasMany(TournamentMatch::class);
    }
}