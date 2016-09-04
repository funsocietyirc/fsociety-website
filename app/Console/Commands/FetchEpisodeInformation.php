<?php

namespace Fsociety\Console\Commands;

use Fsociety\Services\EpisodeService;
use Illuminate\Console\Command;

class FetchEpisodeInformation extends Command
{


    protected $signature = 'fsociety:fetchEpisodes';
    protected $description = 'Fetch episode metadata';
    protected $episodeService;

    /**
     * Create a new command instance.
     * @param EpisodeService $episodeService
     */
    public function __construct(EpisodeService $episodeService)
    {
        parent::__construct();
        $this->episodeService = $episodeService;
    }


    public function handle()
    {
        $response = $this->episodeService->propagateEpisodes();
        if ($response) {
            $this->info('Successfully propagated Episode information');
            return;
        }
        $this->error('Error propagating episode information');
    }
}
