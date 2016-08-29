<?php
namespace Fsociety\Services;

use Fsociety\Models\Episode;

class EpisodeService
{
    public function getEpisodesIndex($season = null) {
        $result = $season ? Episode::select([
            'name',
            'imageMedium',
            'season_id',
            'number'
        ])->whereSeasonId($season)->orderBy('season_id')->orderBy('number')->get() : Episode::orderBy('season_id')->orderBy('number')->get();
        if(!$result->count()) {
            throw new EpisodeNotFoundException;
        }
        return $result;
    }

    public function getEpisodePage($season, $episode)
    {
        $result = Episode::whereNumber($episode)->whereSeasonId($season)->first();
        if(!$result) {
            throw new EpisodeNotFoundException;
        }
        return $result;
    }
}