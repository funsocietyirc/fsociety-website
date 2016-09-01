<?php

use Illuminate\Database\Seeder;
use Fsociety\Services\EpisodeService;

class EpisodeSeeder extends Seeder
{

    protected $episodeService;
    public function __construct(EpisodeService $episodeService)
    {
        $this->episodeService = $episodeService;
    }

    public function run()
    {
        $this->episodeService->propagateEpisodes();
    }
}
