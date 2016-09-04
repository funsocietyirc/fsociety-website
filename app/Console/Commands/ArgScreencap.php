<?php

namespace Fsociety\Console\Commands;

use Fsociety\Services\ArgService;
use Illuminate\Console\Command;

class ArgScreencap extends Command
{

    protected $signature = 'fsociety:screenCapArg {url}';
    protected $description = 'Screen capture a ARG';
    protected $argService;

    /**
     * Create a new command instance.
     *
     * @param ArgService $argService
     */
    public function __construct(ArgService $argService)
    {
        parent::__construct();
        $this->argService = $argService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = $this->argService->fetchArgTileByUrl($this->argument('url'));
        if ($response) {
            $this->info('Arg Tile download complete');
            return;
        }
        $this->error('Arg Tile download failed');
    }
}
