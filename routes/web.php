<?php

use App\Models\Video;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/webhook/encoding', 'EncodingWebhookController@handle');

Route::get('/videos/{video}', 'VideoController@show');
Route::post('/videos/{video}/views','VideoViewController@create');
Route::get('/search','SearchController@index');

Route::get('/videos/{video}/vote','VideoVoteController@show');
Route::get('/videos/{video}/comments','VideoCommentController@index');

Route::get('/subscription/{channel}', 'ChannelSubscriptionController@show');

Route::get('/channel/{channel}', 'ChannelController@show');

Route::group(['middleware'=>['auth']], function(){
	Route::get('/upload', 'VideoUploadController@index');
	Route::post('/upload', 'VideoUploadController@store');

	Route::get('/videos', 'VideoController@index');
	Route::get('/videos/{video}/edit', 'VideoController@edit');
	Route::post('/videos', 'VideoController@store');
	Route::delete('/videos/{video}', 'VideoController@delete');
	Route::put('/videos/{video}', 'VideoController@update');

	Route::get('/channel/{channel}/edit', 'ChannelController@edit');
	Route::put('/channel/{channel}/edit', 'ChannelController@update');

	Route::post('/videos/{video}/vote', 'VideoVoteController@create');
	Route::delete('/videos/{video}/vote', 'VideoVoteController@remove');

	Route::post('/videos/{video}/comments','VideoCommentController@create');
	Route::delete('/videos/{video}/comments/{comment}','VideoCommentController@delete');

	Route::post('subscription/{channel}', 'ChannelSubscriptionController@create');
	Route::delete('subscription/{channel}', 'ChannelSubscriptionController@delete');

});

Route::get('/restore', function(){
	Video::withTrashed()->find(1)->restore();
});