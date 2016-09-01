<?php

namespace Fsociety\Http\Controllers;

use Auth;
use Fsociety\Models\ArgTracking;
use Fsociety\Services\ArgService;
use Gate;
use Illuminate\Http\Request;

use Fsociety\Http\Requests;
use Illuminate\Pagination\Paginator;

class ArgController extends Controller
{

    protected $argService;
    public function __construct(ArgService $argService)
    {
        $this->argService = $argService;
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $results = ArgTracking::with('creator')->get();
        return view('arg.index')->with('results', $results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('arg.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required|max:255',
            'url'    => 'required|url|unique:arg_tracking',
            'description' => 'max:500'
        ]);
        ArgTracking::create([
            'user_id'   => Auth::user()->id,
            'url'   => $request->input('url'),
            'name'  =>  $request->input('name'),
            'description' => $request->input('description')
        ]);
        flash('Thank you for sharing');
        return redirect()->route('arg.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Capture Arg Tile
    public function capture(ArgTracking $model) {
        $result = $this->argService->fetchArgTileByUrl($model->url);
        if($result) {
            flash()->overlay('Arg Tile generated', 'Bleep Bloop Blip');
        } else {
            flash()->overlay('Error generating ARG tile', 'Bleep Bloop Blip');
        }
        return redirect()->back();
    }
}
