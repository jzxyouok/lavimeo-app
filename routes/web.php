<?php


Route::get('/', function () {
    return view('welcome');
});


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
