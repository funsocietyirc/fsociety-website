<?php
namespace fsociety\Services;

use fsociety\Episode;

class EpisodeService
{
    public function getEpisodes() {
        return Episode::all();
    }
}