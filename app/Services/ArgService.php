<?php
namespace Fsociety\Services;

use Auth;
use File;
use Fsociety\Events\ArgLinkCreatedEvent;
use Fsociety\Events\ArgLinkHashUpdateEvent;
use Fsociety\Models\ArgSeasonEpisode;
use Fsociety\Models\ArgTracking;
use Fsociety\Models\Episode;
use Fsociety\Models\User;


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
    public function fetchArgTileByUrl(string $url)
    {
        $record = ArgTracking::where('url', $url)->first();
        if (!$record) {
            return false;
        }
        File::copy(
            self::fetchUrl . $record->url,
            public_path('images/arg/tiles/' . $record->id . '.png')
        );
        return true;
    }

    /**
     * Delete a ARG Tracking link
     * @param ArgTracking $arg
     */
    public function delete(ArgTracking $arg)
    {
        // Remove the TILE
        if (File::exists(public_path('images/arg/tiles/' . $arg->id . '.png'))) {
            File::delete(public_path('images/arg/tiles/' . $arg->id . '.png'));
        }

        // Delete the record
        $arg->delete();
    }

    /**
     * Create a connection between a ARG Link and an Episode
     * @param ArgTracking $arg
     * @param int $episodeId
     */
    public function createConnection(ArgTracking $arg, int $episodeId)
    {
        $connection = new ArgSeasonEpisode();
        $connection->episode_id = Episode::findOrFail($episodeId)->id;
        $arg->connections()->save($connection);
    }

    /**
     * Create a ARG Link
     * @param string $name
     * @param string $url
     * @param string $description
     * @param User $creator
     * @return bool
     * @throws SiteNotFoundException
     */
    public function create(string $name, string $url, string $description, User $creator) {
        $contents = @file_get_contents($url);
        if(!$contents) {
            throw new SiteNotFoundException;
        }
        $arg = ArgTracking::create([
            'user_id' => $creator->id,
            'name' => $name,
            'url' => $url,
            'description' => trim($description)
        ]);
        // Fire the event
        event(new ArgLinkCreatedEvent($arg, $creator));
        return true;
    }

    /*
     * Check the hash of the url to see if it has changed
     * This modified the updated_at field and provides us with a last date modified
     * @param ArgTracking $arg
     * @return bool true if update false if not
     */
    public function updateArgLinkHash(ArgTracking $arg) {
        // We are ignoring this hash
        if($arg->ignoreHash) {
            return false;
        }
        $contents = @file_get_contents($arg->url);
        if(!$contents) {
            return false;
        }
        $hash = md5($contents);
        if(!$arg->hash || $arg->hash != $hash) {
            if(!$arg->hash) {
                $arg->timestamps = false;
            } else {
                event(new ArgLinkHashUpdateEvent($arg, Auth::user() ?? User::first() ));
            }
            $arg->update(['hash' => $hash]);
            return true;
        }
        return false;
    }

    /**
     * @param ArgTracking $arg
     * @return bool
     */
    public function flipWatchStatus(ArgTracking $arg)
    {
        $arg->timestamps = false;
        $arg->update([
            'ignoreHash' => !$arg->ignoreHash
        ]);
        $arg->timestamps = true;
        return $arg->ignoreHash;
    }

}
