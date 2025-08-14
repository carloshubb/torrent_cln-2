<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopularTorrent extends Model
{
    //
    protected $table = 'popular_torrents';

    protected $fillable = [
        'subcategory_id',
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

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
