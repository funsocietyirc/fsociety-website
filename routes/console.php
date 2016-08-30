<?php

use Illuminate\Foundation\Inspiring;
use Symfony\Component\Finder\Finder;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
});

// Clean dynamic uploads
Artisan::command('fsociety:clean-episodes', function() {
    $files = Finder::create()
        ->in(public_path('images/arg/tiles'))
        ->in(public_path('images/episodes/screens'))
        ->name('/^.*\.(jpg|jpeg|png|gif)$/i');
    foreach ($files as $file) {
        $this->info($file);
    }
    if (!$this->confirm('Do you wish to continue? [y|N]')) {
        $this->info('Deletion aborted.');
        return;
    }
    foreach ($files as $file) {
        unlink($file);
    }
    $this->info("{$files->count()} total files deleted");
})->describe('Clean up episode images');
