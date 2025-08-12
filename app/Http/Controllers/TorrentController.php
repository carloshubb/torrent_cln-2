<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Torrent;
use App\Models\PopularTorrent;
use App\Models\HomeImageList;

class TorrentController extends Controller
{
    //

    public function getByType(Request $request)
    {
        $type = $request->query('type'); // 'mostpopular'        
        // Fetch torrents based on type
        if ($type === 'mostpopular') {
            $torrents = PopularTorrent::where('category_title', 'Most Popular Torrents this week')
                ->paginate(10);
        } // Fetch most movie torrents based on type
        else if ($type === 'popularmovie') {
            $torrents = PopularTorrent::where('category_title', 'Popular Movie Torrents')
                ->paginate(10);
        } // Fetch most foreign movie torrents based on type
        else if ($type === 'popularforeignmovie') {
            $torrents = PopularTorrent::where('category_title', 'Popular Foreign Movie Torrents')
                ->paginate(10);
        } // Fetch most TV torrents based on type
        else if ($type === 'populartv') {
            $torrents = PopularTorrent::where('category_title', 'Popular TV Torrents')
                ->paginate(10);
        } // Fetch most Game torrents based on type
        else if ($type === 'populargame') {
            $torrents = PopularTorrent::where('category_title', 'Popular Game Torrents')
                ->paginate(10);
        } // Fetch most Music torrents based on type
        else if ($type === 'popularmusic') {
            $torrents = PopularTorrent::where('category_title', 'Popular Music Torrents')
                ->paginate(10);
        } // Fetch most Application torrents based on type
        else if ($type === 'popularapplication') {
            $torrents = PopularTorrent::where('category_title', 'Popular Application Torrents')
                ->paginate(10);
        } // Fetch most Application torrents based on type
        else if ($type === 'popularother') {
            $torrents = PopularTorrent::where('category_title', 'Popular Other Torrents')
                ->paginate(10);
        } // Fetch most Sub Category torrents based on type
        else if ($type === 'subcategory') {
            $subcategory = $request->query('sub_cat');
            $currentPage = $request->query('page', 1); // get 'page' from query string, default to 1
            //dd($subcategory);
            $torrents = Torrent::where('sub_category_id', $subcategory)
                ->orderByDesc('approved_at')
                ->paginate(10, ['*'], 'page', $currentPage + 1);
        } // Fetch most Category torrents based on type
        else if ($type === 'category') {
            $category = $request->query('cat');
            $currentPage = $request->query('page', 1); // get 'page' from query string, default to 1
            //dd($category);
            $torrents = Torrent::whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            })->orderByDesc('approved_at')
                ->paginate(10, ['*'], 'page', $currentPage);
        } // Fetch most Category torrents based on type
        else if ($type === 'trending') {
            $torrents = PopularTorrent::where('category_title', 'Trending Torrents last 24 hours')
                ->paginate(10000);
        } // Fetch most Category torrents based on type
        else if ($type === 'top') {
            $torrents = PopularTorrent::where('category_title', 'top 100 Torrents')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'homeimage') {
            $torrents = HomeImageList::all();
        } else {
            //$torrents = Torrent::all();
        }

        return response()->json($torrents);
    }


    public function getDetailData($id, $slug)
    {
        
        $torrent = Torrent::with('detail') // eager load related data
            ->where('id', $id)
            ->where('slug', $slug)
            ->firstOrFail();
        //dd($torrent);
        return response()->json($torrent);
    }
}
