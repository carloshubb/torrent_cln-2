<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopularTorrent extends Model
{
    //
    protected $table = 'popular_torrents';

    protected $fillable = [
        'sub_category_id',
        'torrent_link',
        'category_title',
        'name',
        'comments_count',
        'seeds',
        'leeches',
        'size',
        'approved_at',
        'uploader',
    ];
}
