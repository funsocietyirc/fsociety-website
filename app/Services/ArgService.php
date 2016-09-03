<?php
namespace Fsociety\Services;

use File;
use Fsociety\Models\ArgSeasonEpisode;
use Fsociety\Models\ArgTracking;
use Fsociety\Models\Episode;


class ArgService
{
    const fetchUrl = 'http://api.screenshotmachine.com/?key=919a63&size=M&format=PNG&cacheLimit=7&timeout=1000&url=';

    public function __construct()
    {
    }

    /**
     * Fetch ARG tile by url
     * @param $url
     * @return bool returns false on error
     */
    public function fetchArgTileByUrl(string $url) {
        $record = ArgTracking::where('url',$url)->first();
        if(!$record) {
            return false;
        }
        File::copy(
            self::fetchUrl . $record->url,
            public_path('images/arg/tiles/'.$record->id . '.png')
        );
        return true;
    }

    /**
     * Delete a ARG Tracking link
     * @param ArgTracking $arg
     */
    public function delete(ArgTracking $arg) {
        // Remove the TILE
        if(File::exists(public_path('images/arg/tiles/' . $arg->id . '.png'))) {
            File::delete(public_path('images/arg/tiles/' . $arg->id . '.png'));
        }

        // Delete the record
        $arg->delete();
    }

    public function createConnection(ArgTracking $arg, int $episodeId) {
        $connection = new ArgSeasonEpisode();
        $connection->episode_id = Episode::findOrFail($episodeId)->id;
        $arg->connections()->save($connection);
    }
}
