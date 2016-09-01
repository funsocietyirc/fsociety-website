<?php
namespace Fsociety\Services;

use File;
use Fsociety\Models\ArgTracking;

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
    public function fetchArgTileByUrl($url) {
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

    public function delete(ArgTracking $arg) {
        // Remove the TILE
        if(File::exists(public_path('images/arg/tiles/' . $arg->id . '.png'))) {
            File::delete(public_path('images/arg/tiles/' . $arg->id . '.png'));
        }

        // Delete the record
        $arg->delete();
    }
}
