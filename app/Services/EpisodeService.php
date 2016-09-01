<?php
namespace Fsociety\Services;

use Fsociety\Models\Episode;
use GuzzleHttp;
use File;

class EpisodeService
{
    protected $showId = 1871;
    protected $tvMazeApi;


    public function __construct()
    {
        $this->tvMazeApi = "http://api.tvmaze.com/shows/{$this->showId}/episodes?specials=1";
    }

    /**
     * Get Information needed to build episode index page
     * @param null $season
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     * @throws EpisodeNotFoundException
     */
    public function getEpisodesIndex($season = null) {
        $result = $season ? Episode::select([
            'name',
            'imageMedium',
            'season_id',
            'number',
            'slug'
        ])->whereSeasonId($season)->orderBy('season_id')->orderBy('number')->get() : Episode::orderBy('season_id')->orderBy('number')->get();
        if(!$result->count()) {
            throw new EpisodeNotFoundException;
        }
        return $result;
    }

    /**
     * Return data used to build Episode Index page
     * @param $slug
     * @return mixed
     * @throws EpisodeNotFoundException
     */
    public function getEpisodePage($slug)
    {
        $result = Episode::where('slug',$slug)->first();
        if(!$result) {
            throw new EpisodeNotFoundException;
        }
        return $result;
    }

    /**
     * (Re)propagate episode information
     * @return bool returns false on error
     */
    public function propagateEpisodes() {
        // Episode seeder (to be extracted into service with command and schedule)
        try {
            $client = new GuzzleHttp\Client();
            $response = $client->get($this->tvMazeApi);
            // Something went wrong with the request
            if ($response->getStatusCode() !== 200) {
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
            return true;

        } catch(GuzzleHttp\Exception\ConnectException $exception) {
            return false;
        }
    }

    /**
     * Save an episode tile
     * @param $url
     * @param $season
     * @param $episode
     * @param $size
     * @return string
     */
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