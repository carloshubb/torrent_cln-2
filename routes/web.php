<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TorrentController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return Inertia::render('Dashboard', [
        'page' => 'dashboard',
        'title' => '1331x.com',
        'params' => ''
    ]);
})->name('home');

Route::get('/sub/{param1}/{param2}', function ($param1, $param2) {
    // You can use $param1 and $param2 here
    return Inertia::render('Dashboard', [
        'page' => 'sub',
        'params' => $param1 . "@" . $param2,
    ]);
});

Route::get('/cat/{param1}/{param2}', function ($param1, $param2) {
    // You can use $param1 and $param2 here
    return Inertia::render('Dashboard', [
        'page' => 'cat',
        'title' => 'Download ' . $param1 . ' Torrents',
        'params' => $param1 . "@" . $param2,
    ]);
});

Route::get('/search/{param1}/{param2}', function ($param1, $param2) {
    // You can use $param1 and $param2 here
    return Inertia::render('Dashboard', [
        'page' => 'search',
        'params' => $param1 . "@" . $param2,
    ]);
});

Route::get('/trending', function () {
    return Inertia::render('Dashboard', [
        'page' => 'trending',
        'title' => 'Trending Torrents',
        'params' => null,
    ]);
});

Route::get('/trending-week', function () {
    return Inertia::render('Dashboard', [
        'page' => 'trending-week',
        'title' => 'Trending Torrents last 7 days',
        'params' => null,
    ]);
});

Route::get('/trending/d/movies/', function () {
    return Inertia::render('Dashboard', [
        'page' => 'trending-d-movies',
        'title' => 'Trending Torrents last 7 days',
        'params' => null,
    ]);
});
Route::get('/trending/d/tv/', function () {
    return Inertia::render('Dashboard', [
        'page' => 'trending-d-tv',
        'title' => 'Trending Torrents last 7 days',
        'params' => null,
    ]);
});
Route::get('/trending/d/games/', function () {
    return Inertia::render('Dashboard', [
        'page' => 'trending-d-games',
        'title' => 'Trending Torrents last 7 days',
        'params' => null,
    ]);
});
Route::get('/trending/d/apps/', function () {
    return Inertia::render('Dashboard', [
        'page' => 'trending-d-apps',
        'title' => 'Trending Torrents last 7 days',
        'params' => null,
    ]);
});

Route::get('/trending/d/music/', function () {
    return Inertia::render('Dashboard', [
        'page' => 'trending-d-music',
        'title' => 'Trending Torrents last 7 days',
        'params' => null,
    ]);
});
Route::get('/trending/d/anime/', function () {
    return Inertia::render('Dashboard', [
        'page' => 'trending-d-anime',
        'title' => 'Trending Torrents last 7 days',
        'params' => null,
    ]);
});

Route::get('/trending/d/other/', function () {
    return Inertia::render('Dashboard', [
        'page' => 'trending-d-other',
        'title' => 'Trending Torrents last 7 days',
        'params' => null,
    ]);
});
Route::get('/trending/d/xxx/', function () {
    return Inertia::render('Dashboard', [
        'page' => 'trending-d-xxx',
        'title' => 'Trending Torrents last 7 days',
        'params' => null,
    ]);
});
Route::get('/trending/d/documentaries/', function () {
    return Inertia::render('Dashboard', [
        'page' => 'trending-d-doc',
        'title' => 'Trending Torrents last 7 days',
        'params' => null,
    ]);
});
Route::get('/top-100', function () {
    return Inertia::render('Dashboard', [
        'page' => 'top',
        'title' => 'Top 100  Torrents This Month',
        'params' => null,
    ]);
});
Route::get('/top-100-movies', function () {
    return Inertia::render('Dashboard', [
        'page' => 'top-100-movies',
        'title' => 'Top 100  Torrents This Month',
        'params' => null,
    ]);
});
Route::get('/top-100-television', function () {
    return Inertia::render('Dashboard', [
        'page' => 'top-100-television',
        'title' => 'Top 100  Torrents This Month',
        'params' => null,
    ]);
});
Route::get('/top-100-games', function () {
    return Inertia::render('Dashboard', [
        'page' => 'top-100-games',
        'title' => 'Top 100  Torrents This Month',
        'params' => null,
    ]);
});
Route::get('/top-100-applications', function () {
    return Inertia::render('Dashboard', [
        'page' => 'top-100-applications',
        'title' => 'Top 100  Torrents This Month',
        'params' => null,
    ]);
});

Route::get('/top-100-anime', function () {
    return Inertia::render('Dashboard', [
        'page' => 'top-100-anime',
        'title' => 'Top 100  Torrents This Month',
        'params' => null,
    ]);
});
Route::get('/top-100-other', function () {
    return Inertia::render('Dashboard', [
        'page' => 'top-100-other',
        'title' => 'Top 100  Torrents This Month',
        'params' => null,
    ]);
});
Route::get('/top-100-xxx', function () {
    return Inertia::render('Dashboard', [
        'page' => 'top-100-xxx',
        'title' => 'Top 100  Torrents This Month',
        'params' => null,
    ]);
});
Route::get('/top-100-documentaries', function () {
    return Inertia::render('Dashboard', [
        'page' => 'top-100-documentaries',
        'title' => 'Top 100  Torrents This Month',
        'params' => null,
    ]);
});
Route::get('/top-100-music', function () {
    return Inertia::render('Dashboard', [
        'page' => 'top-100-music',
        'title' => 'Top 100  Torrents This Month',
        'params' => null,
    ]);
});



Route::get('/torrent/{param1}/{param2}', function ($param1, $param2) {
    // You can use $param1 and $param2 here
    
    return Inertia::render('DetailTable', [
        'page' => 'detail',
        'title' => 'Download ' . $param2 . ' Torrent',
        'torrent_id' => $param1,
        'torrent_slug' => $param2,
    ]);
});

Route::get('/movielibrary/{param1}/', function ($param1) {
    return Inertia::render('MovieLibrary', [
        'page' => 'movielibrary',
        'title' => 'Movie Library',
        'page' => $param1
    ]);
});

Route::get('/movie/{param1}/{param2}/',[TorrentController::class,'movie']);



Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->get('/me', [LoginController::class, 'me']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/uploadtest', [TorrentController::class, 'uploadtorrent']);
Route::get('/uploads', [TorrentController::class, 'uploads']);
Route::post('/torrents', [TorrentController::class, 'store'])->name('torrents.store');
Route::get('/user/{param1}/{param2?}', [UserController::class, 'index'])->name('torrents.user');

Route::get('/home', function () {
    return Inertia::render('Home', [
        'message' => 'Hello from Laravel!'
    ]);
});
Route::get('/category', function () {
    return Inertia::render('Category');
});
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'page' => 'dashboard',
        'params' => ''
    ]);
});
Route::get('/detailpage', function () {
    return Inertia::render('Detailpage');
});
Route::get('/test', function () {
    return Inertia::render('Test');
});
Route::get('/detailtable', function () {
    return Inertia::render('DetailTable');
});
Route::get('/rules', function () {
    return Inertia::render('Rules');
});
Route::get('/contact', function () {
    return Inertia::render('Contact');
});
Route::get('/about', function () {
    return Inertia::render('About');
});
Route::get('/upload', function () {
    $user = Auth::user();

    // If not logged in, redirect to login page
    if ($user === null) {
        // Option 1: Relative redirect (simplest, avoids APP_URL issues)
        return redirect('/login');

        // Option 2: Named route, make sure it exists
        // return redirect()->route('login');
    }

    // If logged in, show Inertia Upload page
    return Inertia::render('Upload');
});


Route::get('/login', function () {
    return Inertia::render('Login');
})->name('login');
Route::get('/icon', function () {
    return Inertia::render('Icon');
});
