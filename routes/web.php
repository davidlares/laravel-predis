<?php
use Illuminate\Support\Facades\Redis;
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

// REDIS Keys PREFIX: laravel_database

Route::get('/', function () {
    return view('welcome');
});

// INCR Example

Route::get('/visits', function () {
    $visits = Redis::incr('visits');
    return view('visits')->with('visits', $visits);
});

// redis NAMESPACE and GET Example

Route::get('/video/{id}', function($id){
  $downloads = Redis::get("videos.$id.downloads");
  return view('downloads')->with('downloads', $downloads);
});

Route::get('/video/{id}/downloads', function($id){
    Redis::incr("videos.$id.downloads");
    return back();
});

// SORTED SETS with Article Models Example

Route::get('articles/trending', function() {
  $trending = Redis::zrevrange('trending', 0, 2); // reversed sorted set range (top 3)
  $trending = App\Article::hydrate(array_map('json_decode', $trending)); // from json to Eloquent model
  dd($trending);
});

Route::get('/articles/{article}', function(App\Article $article) {
  // creating key if not exists
  Redis::zincrby('trending', 1, $article); // incrementing by one ()
  return $article;
});

// HASHES examples

Route::get('/hashes', function() {
  // instead of processing sql -> redis to isolate calculations
  $userStats = ['favorites' => 10, 'watchLater' => 20, 'completions' => 30];
  // Redis::hmset('users.2.stats', $userStats);
  return Redis::command("hmset",["users.2.stats", $userStats]);
});

Route::get('users/{id}/stats', function($id) {
  return Redis::command("hgetall",["users.{$id}.stats"]);
});

Route::get('favorite-video/{id}', function($id) {
  Redis::command("hincrby",["users.{$id}.stats", 'favorites', 1]);
  return back();
});

// Laravel CACHE with Redis

Route::get('/cache', function() {
  Cache::put('foo', ['name' => 'David', 'age' => 3], 10); // 3rd params = 10 mins
  return Cache::get('foo'); // Laravel uses as well a prefix
});
