<?php
use fsociety\Episode;
use fsociety\Season;
use Illuminate\Database\Seeder;


class seasonSeeder extends Seeder
{
    protected $showId = 1871;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Initial Season Seed
        collect([
            '1' => 'Our democracy has been hacked.',
            '2' => 'Control is an illusion.',
        ])->each(function ($value, $key) {
            Season::firstOrCreate([
                'number' => $key,
                'tagline' => $value
            ]);
        });

        // Episode seeder (to be extracted into service with command and schedule)
        $client = new GuzzleHttp\Client();
        $response = $client->get('http://api.tvmaze.com/shows/1871/episodes');
        // Something went wrong with the request
        if ($response->getStatusCode() !== 200) {
            return;
        }
        $data = json_decode($response->getBody(), true);
        foreach ($data as $episode) {
            $model = Episode::firstOrNew([
                'season_id' => $episode['season'],
                'name' => $episode['name'],
                'number' => $episode['number'],
                'airdate' => $episode['airdate'],
                'airtime' => $episode['airtime'],
                'airstamp' => $episode['airstamp'],
                'runtime' => $episode['runtime'],
                'imageMedium' => $episode['image']['medium'],
                'imageOriginal' => $episode['image']['original'],
                'summary' => strip_tags($episode['summary'])
            ]);

            // Gran the images and save if the model does not alreadye exist
            if(!$model->id) {
                if ($episode['image']['medium']) {
                    $path = $this->saveImage($episode['image']['medium'],$episode['season'], $episode['number'],'medium');
                    $model->imageMedium = asset($path);
                }

                if ($episode['image']['original']) {
                    $path = $this->saveImage($episode['image']['original'],$episode['season'], $episode['number'],'original');
                    $model->imageOriginal = asset($path);
                }
            }
            $model->save();
        }
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
}
