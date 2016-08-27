<?php
// Base Routes
Route::group(['prefix' => '/'], function () {
    Route::get('/', function () {
        return view('index');
    })->name('home');
    Route::get('chat', function() {
        return view('chat');
    })->name('chat');
});
// Episode Routes
Route::group(['prefix' => 'episodes'], function () {
    Route::get('/', 'EpisodeController@index')->name('episodes');
    Route::get('season/{season}','EpisodeController@season')->name('season');
    Route::get('show/{season}/{episode}','EpisodeController@show')->name('episode');
});
// Arg Routes
Route::resource('arg', 'ArgController');
// Authentication Routes
Auth::routes();


