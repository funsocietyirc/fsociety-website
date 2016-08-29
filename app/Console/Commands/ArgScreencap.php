<?php

namespace Fsociety\Console\Commands;

use File;
use Fsociety\Models\ArgTracking;
use Illuminate\Console\Command;
use Illuminate\Pagination\Paginator;

class ArgScreencap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fsociety:caparg {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Screen capture a ARG';
    const fetchUrl = 'http://api.screenshotmachine.com/?key=919a63&size=M&format=PNG&cacheLimit=7&timeout=1000&url=';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $record = ArgTracking::where('url',$this->argument('url'))->first();
        if(!$record) {
            $this->error('The ARG you are looking for does not exist');
            return false;
        }
        File::copy(
            self::fetchUrl . $record->url,
            public_path('images/arg/tiles/'.$record->id . '.png')
        );
        $this->info('Finished Downloading screen shot');
        return true;
    }
}
