<?php

namespace Fsociety\Http\Controllers;

use Auth;
use File;
use Fsociety\Models\ArgTracking;
use Fsociety\Services\ArgService;
use Illuminate\Http\Request;

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
            'name' => trim($request->input('name')),
            'url'  => trim($request->input('url')),
            'description' => trim($request->input('description'))
        ]);
        flash('Thank you for sharing');
        return redirect()->route('arg.index');
    }

    /**
     * Display the specified resource.
     *
     * @param ArgTracking $arg
     * @return \Illuminate\Http\Response
     */
    public function show(ArgTracking $arg)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ArgTracking $arg
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(ArgTracking $arg)
    {
        return view('arg.edit')->with('arg', $arg);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param ArgTracking $arg
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ArgTracking $arg)
    {
        $this->authorize('edit', $arg);
        $this->validate($request, [
            'name'   => 'required|max:255',
            'url'    => 'required|url',
            'description' => 'max:500'
        ]);

        $arg->update([
            'name' => trim($request->input('name')),
            'url'  => trim($request->input('url')),
            'description' => trim($request->input('description'))
        ]);

        return redirect()->route('arg.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ArgTracking $arg
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArgTracking $arg)
    {
        $this->authorize('delete', $arg);

        // Remove the TILE
        if(File::exists(public_path('images/arg/tiles/' . $arg->id . '.png'))) {
            File::delete(public_path('images/arg/tiles/' . $arg->id . '.png'));
        }

        // Delete the record
        $arg->delete();

        flash()->overlay('The ARG Link has been Deleted', 'Arg Link');
        return redirect()->route('arg.index');
    }

    /**
     * @param ArgTracking $arg
     * @return \Illuminate\Http\RedirectResponse
     */
    public function capture(ArgTracking $arg) {
        $this->authorize('capture', $arg);
        $result = $this->argService->fetchArgTileByUrl($arg->url);
        if(!$result) {
            flash()->overlay('Something went wrong capturing the ARG tile', 'ARG Link');
        }
        return redirect()->route('arg.index');
    }
}
