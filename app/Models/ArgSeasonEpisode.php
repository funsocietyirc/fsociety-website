<?php

namespace Fsociety\Models;

use Illuminate\Database\Eloquent\Model;

class ArgSeasonEpisode extends Model
{
    protected $table = 'arg_season_episode';

    protected $guarded = [
        'id'
    ];

    public function episode() {
        return $this->belongsTo(Episode::class, 'episode_id');
    }

    public function season() {
        return $this->belongsTo(Season::class, 'season_id');
    }

    public function argLink() {
        return $this->belongsTo(ArgTracking::class, 'arg_id');
    }
}
