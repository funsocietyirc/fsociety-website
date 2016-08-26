<?php
namespace fsociety\Services;

use fsociety\Episode;

class EpisodeService
{
    public function getEpisodesIndex($season = null) {
        return $season ? Episode::select([
            'name',
            'imageMedium'
        ])->whereSeasonId($season)->get() : Episode::all();
    }

    public function getEpisodePage($season, $episode)
    {
        return Episode::whereNumber($episode)->whereSeasonId($season)->first();
    }
}