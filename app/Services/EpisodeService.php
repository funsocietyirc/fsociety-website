<?php
namespace fsociety\Services;

use fsociety\Episode;

class EpisodeService
{
    public function getEpisodes($season = null) {
        return $season ? Episode::whereSeasonId($season)->get() : Episode::all();
    }
}