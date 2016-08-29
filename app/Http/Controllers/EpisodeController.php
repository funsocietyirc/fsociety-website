<?php

namespace Fsociety\Http\Controllers;

use Fsociety\Services\EpisodeNotFoundException;
use Fsociety\Services\EpisodeService;
use Illuminate\Http\Request;

use Fsociety\Http\Requests;

class EpisodeController extends Controller
{
    protected $episodeService;
    const EpisodeNotFoundMessage = 'Our systems have been compromised, or the Episode you seek does not yet exist.';
    const EpisodeNotFoundTitle = 'I am unable to do that...';
    public function __construct(EpisodeService $episodeService)
    {
        $this->episodeService = $episodeService;
    }

    public function index() {
        return view('episodes.index')->with('episodes', $this->episodeService->getEpisodesIndex());
    }

    public function season($season) {
        try {
            return view('episodes.index')->with('episodes', $this->episodeService->getEpisodesIndex($season));
        } catch (EpisodeNotFoundException $exception) {
            flash()->overlay(self::EpisodeNotFoundMessage, self::EpisodeNotFoundTitle);
            return redirect()->route('episodes');
        }
    }

    public function show($slug) {
        try {
            return view('episodes.show')
                ->with('episode', $this->episodeService->getEpisodePage($slug));
        } catch (EpisodeNotFoundException $exception) {
            flash()->overlay(self::EpisodeNotFoundMessage, self::EpisodeNotFoundTitle);
            return redirect()->route('episodes');
        }
    }
}
