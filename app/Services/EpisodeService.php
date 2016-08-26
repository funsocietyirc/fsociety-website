<?php
namespace fsociety\Services;

use fsociety\Episode;

class EpisodeService
{
    public function getEpisodesIndex($season = null) {
        return $season ? Episode::select([
            'name',
            'imageMedium',
            'season_id',
            'number'
        ])->whereSeasonId($season)->orderBy('season_id')->orderBy('number')->get() : Episode::orderBy('season_id')->orderBy('number')->get();
    }

    public function getEpisodePage($season, $episode)
    {
        return Episode::whereNumber($episode)->whereSeasonId($season)->first();
    }
}