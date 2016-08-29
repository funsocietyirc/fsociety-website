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
    Route::get('show/{slug}','EpisodeController@show')->name('episode');
});
// Arg Routes
Route::resource('arg', 'ArgController');

// Authentication Routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

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



