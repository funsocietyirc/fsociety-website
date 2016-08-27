<?php

namespace Fsociety\Console\Commands;

use Illuminate\Console\Command;
use Fsociety\Episode;
use GuzzleHttp;
use File;

class fetchEpisodeInformation extends Command
{

    protected $signature = 'fsociety:fetchEpisodes';
    protected $description = 'Fetch episode metadata';
    protected $showId = 1871;

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function saveImage($url, $season, $episode, $size)
    {
        $screenLocation = 'images/episodes/screens';
        $relPath =  public_path($screenLocation) . '/';
        $path = 's' . $season . 'e'. $episode . $size . '.'. pathinfo(parse_url($url)['path'], PATHINFO_EXTENSION);
        File::copy(
            $url,
            $relPath . $path
        );
        return $screenLocation . '/'. $path;
    }


    public function handle()
    {

        // Episode seeder (to be extracted into service with command and schedule)
        try {
            $client = new GuzzleHttp\Client();
            $response = $client->get('http://api.tvmaze.com/shows/1871/episodes?specials=1');
            // Something went wrong with the request
            if ($response->getStatusCode() !== 200) {
                $this->error('Episode meta-data service not available');
                return false;
            }
            $data = json_decode($response->getBody(), true);
            foreach ($data as $episode) {
                $model = Episode::firstOrNew([
                    'season_id' => $episode['season'],
                    'name' => $episode['name'],
                    'number' => $episode['number'] ? $episode['number'] : '0',
                ]);

                $model->airdate = $episode['airdate'];
                $model->airtime = $episode['airtime'];
                $model->airstamp = $episode['airstamp'];
                $model->runtime = $episode['runtime'];
                $model->summary = strip_tags($episode['summary']);

                // Gran the images and save if the model does not alreadye exist
                if(!$model->imageMedium && $episode['image']['medium']) {
                    if ($episode['image']['medium']) {
                        $path = $this->saveImage($episode['image']['medium'],$episode['season'], $episode['number'],'medium');
                        $model->imageMedium = asset($path);
                    }

                    if (!$model->imageOriginal && $episode['image']['original']) {
                        $path = $this->saveImage($episode['image']['original'],$episode['season'], $episode['number'],'original');
                        $model->imageOriginal = asset($path);
                    }
                }
                $model->save();
            }
            $this->info('Finished getting Episode meta-data');
            return true;

        } catch(GuzzleHttp\Exception\ConnectException $exception) {
            $this->error('Unable to fetch Episode meta-data');
        }
        return false;
    }
}
