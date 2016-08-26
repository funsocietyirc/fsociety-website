<?php

namespace fsociety\Http\Controllers;

use fsociety\Services\EpisodeService;
use Illuminate\Http\Request;

use fsociety\Http\Requests;

class EpisodeController extends Controller
{
    protected $episodeService;
    public function __construct(EpisodeService $episodeService)
    {
        $this->episodeService = $episodeService;
    }

    public function index() {
        return view('episodes.index')->with('episodes', $this->episodeService->getEpisodesIndex());
    }

    public function season($season) {
        return view('episodes.index')->with('episodes', $this->episodeService->getEpisodesIndex($season));
    }

    public function show($season, $episode) {
        return view('episodes.show')->with('episode', $this->episodeService->getEpisodePage($season, $episode));
    }
}
