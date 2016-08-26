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
        return view('episodes')->with('episodes', $this->episodeService->getEpisodes());
    }

    public function season($season) {
        return view('episodes')->with('episodes', $this->episodeService->getEpisodes($season));
    }
}
