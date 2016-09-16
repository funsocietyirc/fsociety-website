<?php

namespace Fsociety\Http\Controllers;

use Fsociety\Http\Requests;
use Fsociety\Services\EpisodeService;
use Fsociety\Services\Exceptions\EpisodeNotFoundException;

class EpisodeController extends Controller
{
    const EpisodeNotFoundMessage = 'Our systems have been compromised, or the Episode you seek does not yet exist.';
    const EpisodeNotFoundTitle = 'I am unable to do that...';
    protected $episodeService;

    public function __construct(EpisodeService $episodeService)
    {
        $this->episodeService = $episodeService;
    }

    public function index()
    {
        try {
            return view('episodes.index')->with('episodes', $this->episodeService->getEpisodesIndex());
        } catch (EpisodeNotFoundException $exception) {
            flash()->overlay('There does not seem to be any Episodes, weiiird...', self::EpisodeNotFoundTitle);
            return redirect()->route('home');
        }
    }

    public function season($season)
    {
        try {
            return view('episodes.index')->with('episodes', $this->episodeService->getEpisodesIndex($season));
        } catch (EpisodeNotFoundException $exception) {
            flash()->overlay(self::EpisodeNotFoundMessage, self::EpisodeNotFoundTitle);
            return redirect()->route('episodes');
        }
    }

    public function show($slug)
    {
        try {
            return view('episodes.show')
                ->with('episode', $this->episodeService->getEpisodePage($slug));
        } catch (EpisodeNotFoundException $exception) {
            flash()->overlay(self::EpisodeNotFoundMessage, self::EpisodeNotFoundTitle);
            return redirect()->route('episodes');
        }
    }
}
