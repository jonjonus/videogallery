<?php

use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

Route::get('/', 'VideosController@index');

Route::resource('clients',   'ClientsController');
// Route::get('clients/{id}/videos','ClientsController@videos');
Route::resource('metatexts',       'MetatextsController');
Route::resource('tagtypes',        'TagtypesController');
Route::resource('tags',            'TagsController');
Route::resource('videos',          'VideosController');

Route::put('videos/{videos}/selection_one',	   	'VideosController@selection_add');
Route::delete('videos/{videos}/selection_one',  'VideosController@selection_remove');
Route::put('videos_selection',				'VideosController@selection_update');
Route::get('videos_selection_show',				'VideosController@selection_show');
Route::get('videos_edit_bulk',		 			'VideosController@editBulk');
Route::get('videos_showPanel',                  'VideosController@showPanel');
Route::get('videos_delete_bulk',                'VideosController@destroyBulk');
Route::post('videos_update_bulk',               'VideosController@updateBulk');
Route::post('videos_update_field/{videos}',		'VideosController@updateField');
Route::get('videos/{videos}/embed',             'VideosController@embedCode');

Route::Controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController']);
Route::auth();

// App::bind('Youtube', function()
// {
// 	$OAUTH2_CLIENT_ID = '739963878733-enlv3314l7j3b52qie1nlb3f7kiio21t.apps.googleusercontent.com';
// 	$OAUTH2_CLIENT_SECRET = 'ZeHAN6hmFCM5B_2sAmTYZXtZ';

// 	$client = new Google_Client();
// 	$client->setClientId($OAUTH2_CLIENT_ID);
// 	$client->setClientSecret($OAUTH2_CLIENT_SECRET);
// 	$client->setScopes('https://www.googleapis.com/auth/youtube');
// 	$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], FILTER_SANITIZE_URL);
// 	$client->setRedirectUri($redirect);
// 	return new Google_Service_YouTube($client);
// });

 Route::get('session', function(Request $request)
 {
 	dd($request->session()->all());
 });

// Video Providers Controller
Route::get('youtube_index',  'YoutubeController@youtube_index');
Route::get('youtube_update', 'YoutubeController@youtube_update');
Route::get('youtube_clear',  'YoutubeController@youtube_clear');

Route::match(array('GET', 'POST'),'vimeo_index', 'YoutubeController@vimeo_index');

//Playlist Controller
Route::resource('playlists',              'PlaylistsController');
Route::put('playlist_add/{videos}',       'PlaylistsController@add');
Route::get('playlist_showPanel',          'PlaylistsController@showPanel');
Route::post('playlist_removeall',         'PlaylistsController@removeall');
Route::post('playlist_updateOrder',       'PlaylistsController@update_order');
Route::post('playlist_load',              'PlaylistsController@load');
Route::delete('playlist_remove/{videos}', 'PlaylistsController@remove');

/* Player */
Route::get('player/id/{playlist}', 'PlayerController@player_by_id');
Route::get('player/{title}', 'PlayerController@player_by_title');

/* DataTables and Editor */
Route::get('datatables_load', 'VideosController@datatables_load');
Route::post('datatables_update', 'VideosController@datatables_update');

/* Cache */
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    dd("cleared.");
});
