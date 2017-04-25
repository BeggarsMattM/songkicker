<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('{artist_id}', function ($artist_id) {

  function sendPost($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
  }

  $result = Cache::remember($artist_id, 5, function () use ($artist_id) {
    $skurl = "http://api.songkick.com/api/3.0/artists/{$artist_id}/calendar/tourbox.json?apikey=" . env(SK_API_KEY);
    return sendPost($skurl);
  });

  return $result;
});
