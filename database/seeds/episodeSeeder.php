<?php

use Illuminate\Database\Seeder;

class episodeSeeder extends Seeder
{

    public function run()
    {
        Artisan::call('fsociety:fetchEpisodes');

    }
}
