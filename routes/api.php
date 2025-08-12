<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TorrentController;
Route::get('/torrents/type', [TorrentController::class, 'getByType']);
Route::get('/torrent/{id}/{slug}', [TorrentController::class, 'getDetailData']);
