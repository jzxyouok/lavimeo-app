<?php

/**
 * videos route except create, edit
 * @link(https://laravel.com/docs/5.4/controllers#resource-controllers)
 */
Route::resource('videos', 'VideoController',[ 'except' => [
	'create', 'edit'
]]);


Route::resource('channels', 'ChannelController',[ 'except' => [
	'create', 'edit'
]]);

Route::resource('commnets', 'CommentController',[ 'except' => [
	'create', 'edit'
]]);
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
