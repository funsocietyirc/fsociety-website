<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('chat', function() {
   return view('chat');
})->name('chat');


Route::group(['prefix' => 'episodes'], function () {
    Route::get('/', 'EpisodeController@index')->name('episodes');
    Route::get('season/{season}','EpisodeController@season')->name('season');
    Route::get('show/{season}/{episode}','EpisodeController@show')->name('episode');
});

Auth::routes();


