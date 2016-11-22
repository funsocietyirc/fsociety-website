<?php

namespace Fsociety\Http\Controllers;

class HomeController extends Controller
{

    public function index()
    {
        return view('index');
    }

    public function gallery() {
        return view('gallery');
    }

    public function links() {
        return view('links');
    }

    public function chat()
    {
        return view('chat');
    }

    public function channel($channel, $nick = '') {
        return view('channel')->with('channel',$channel)->with('nick',$nick);
    }
}
