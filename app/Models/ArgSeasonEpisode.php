<?php

namespace Fsociety\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Fsociety\Models\ArgSeasonEpisode
 *
 * @property integer $id
 * @property integer $arg_id
 * @property integer $episode_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Fsociety\Models\Episode $episode
 * @property-read \Fsociety\Models\Season $season
 * @property-read \Fsociety\Models\ArgTracking $argLink
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\ArgSeasonEpisode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\ArgSeasonEpisode whereArgId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\ArgSeasonEpisode whereEpisodeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\ArgSeasonEpisode whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fsociety\Models\ArgSeasonEpisode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArgSeasonEpisode extends Model
{
    protected $table = 'arg_season_episode';

    protected $guarded = [
        'id'
    ];

    public function episode()
    {
        return $this->belongsTo(Episode::class, 'episode_id');
    }

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id');
    }

    public function argLink()
    {
        return $this->belongsTo(ArgTracking::class, 'arg_id');
    }

}
