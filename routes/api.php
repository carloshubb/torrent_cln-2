<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TorrentController;
Route::get('/torrents/type', [TorrentController::class, 'getByType']);
Route::get('/torrents/categorydata', [TorrentController::class, 'getCategory']);
Route::get('/torrent/{id}/{slug}', [TorrentController::class, 'getDetailData']);
Route::get('/library/movies', [TorrentController::class, 'getMovieLibraryData']);
Route::post('/torrents/delete', [TorrentController::class, 'delete'])->name('upload.delete');
Route::get('/option/category', [TorrentController::class, 'getOptionCategory']);
Route::get('/option/torrent', [TorrentController::class, 'getOptionTorrent']);

