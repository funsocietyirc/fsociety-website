<?php

// Base Routes
Route::group(['prefix' => '/'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('chat', 'HomeController@chat')->name('chat');
});

// cors enabled non indexed
Route::group(['prefix' => '/', 'middleware' => ['cors','no.follow']], function () {
    Route::get('gallery', 'HomeController@gallery')->name('gallery');
    Route::get('links/{search?}', 'HomeController@links')->name('links');
    Route::get('channel/{channel}/{nick?}', 'HomeController@channel')->name('channel');
    Route::get('channels', 'HomeController@ircChannels')->name('irc-channels');
    Route::get('watch-youtube', 'HomeController@watchYoutube')->name('watch-youtube');
});

// Episode Routes
Route::group(['prefix' => 'episodes'], function () {
    Route::get('/', 'EpisodeController@index')->name('episodes');
    Route::get('season/{season}','EpisodeController@season')->name('season');
    Route::get('show/{slug}','EpisodeController@show')->name('episode');
});

// Arg Routes
Route::model('arg', \Fsociety\Models\ArgTracking::class);
Route::get('arg/capture/{arg}','ArgController@capture')->name('arg.capture');
Route::patch('arg/watch/{arg}', 'ArgController@watch')->name('arg.watch');

Route::post('arg/connect/{arg}','ArgController@connect')->name('arg.connect');
Route::resource('arg', 'ArgController');

// Authentication Routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');
Route::get('auth/github', 'Auth\GithubController@redirectToProvider');
Route::get('auth/github/callback', 'Auth\GithubController@handleProviderCallback');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::group(['prefix' => 'password'], function () {
    Route::get('reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('reset');
    Route::post('email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('form');
    Route::post('reset', 'Auth\ResetPasswordController@reset');
});


