<?php

namespace Fsociety\Console\Commands;

use Fsociety\Models\ArgTracking;
use Fsociety\Services\ArgService;
use Illuminate\Console\Command;

class updateArgLinks extends Command
{
    protected $signature = 'fsociety:updateArgLinks';
    protected $description = 'Update modified time if a Arg Link changes';
    protected $argService;

    public function __construct(ArgService $argService)
    {
        parent::__construct();
        $this->argService = $argService;
    }

    public function handle()
    {
        ArgTracking::all()->each(function($arg){
           if($this->argService->updateArgLinkHash($arg)) {
               $this->info("{$arg->name} has been updated");
           }
        });
    }
}
