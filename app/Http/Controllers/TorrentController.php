<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use SandFox\Bencode\Bencode;
use App\Models\Torrent;
use App\Models\PopularTorrent;
use App\Models\HomeImageList;
use App\Models\MovieLibrary;
use App\Models\SubCategory;
use App\Models\TorrentDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class TorrentController extends Controller
{
    //

    public function getByType(Request $request)
    {
        $type = $request->query('type'); // 'mostpopular'        
        // Fetch torrents based on type
        if ($type === 'mostpopular') {
            $torrents['data'] = PopularTorrent::with('subcategory')
                ->where('category_title', 'Most Popular Torrents this week')
                ->paginate(10);
        } // Fetch most movie torrents based on type
        else if ($type === 'popularmovie') {
            $torrents['data'] = PopularTorrent::with('subcategory')
                ->where('category_title', 'Popular Movie Torrents')
                ->paginate(10);
        } // Fetch most foreign movie torrents based on type
        else if ($type === 'popularforeignmovie') {
            $torrents['data'] = PopularTorrent::with('subcategory')
                ->where('category_title', 'Popular Foreign Movie Torrents')
                ->paginate(10);
        } // Fetch most TV torrents based on type
        else if ($type === 'populartv') {
            $torrents['data'] = PopularTorrent::with('subcategory')
                ->where('category_title', 'Popular TV Torrents')
                ->paginate(10);
        } // Fetch most Game torrents based on type
        else if ($type === 'populargame') {
            $torrents['data'] = PopularTorrent::with('subcategory')
                ->where('category_title', 'Popular Game Torrents')
                ->paginate(10);
        } // Fetch most Music torrents based on type
        else if ($type === 'popularmusic') {
            $torrents['data'] = PopularTorrent::with('subcategory')
                ->where('category_title', 'Popular Music Torrents')
                ->paginate(10);
        } // Fetch most Application torrents based on type
        else if ($type === 'popularapplication') {
            $torrents['data'] = PopularTorrent::with('subcategory')
                ->where('category_title', 'Popular Application Torrents')
                ->paginate(10);
        } // Fetch most Application torrents based on type
        else if ($type === 'popularother') {
            $torrents['data'] = PopularTorrent::with('subcategory')
                ->where('category_title', 'Popular Other Torrents')
                ->paginate(10);
        } // Fetch most Sub Category torrents based on type
        else if ($type === 'subcategory') {
            $subcategory = $request->query('sub_cat');
            $currentPage = $request->query('page', 1); // get 'page' from query string, default to 1
            //dd($subcategory);
            $torrents['data'] = Torrent::with('subcategory')->where('subcategory_id', $subcategory)
                ->orderByDesc('approved_at')
                ->paginate(10, ['*'], 'page', $currentPage + 1);
        } // Fetch most Category torrents based on type
        else if ($type === 'category') {
            $category = $request->query('cat');
            $currentPage = $request->query('page', 1); // get 'page' from query string, default to 1
            //dd($category);
            $torrents['data'] = Torrent::with(['category', 'subcategory'])
                ->whereHas('category', function ($query) use ($category) {
                    $query->where('slug', $category);
                })
                ->orderByDesc('approved_at')
                ->paginate(10, ['*'], 'page', $currentPage);
            $torrents['subcategories'] = SubCategory::with(['category',])
                ->whereHas('category', function ($query) use ($category) {
                    $query->where('slug', $category);
                })->get();
        } // Fetch most Category torrents based on type
        else if ($type === 'trending') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'Trending Torrents last 24 hours')
                ->paginate(10000);
        } // Fetch most Category torrents based on type
        else if ($type === 'top') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'top 100 Torrents')
                ->paginate(10000);
        } // Fetch most Category torrents based on type
        else if ($type === 'homeimage') {
            $torrents['data'] = HomeImageList::all();
        } // Fetch Search Torrent Data
        else if ($type === 'search') {
            $search = $request->query('search');
            //dd($search);
            $page = $request->query('page');
            $search = trim($search);
            $torrents['data'] = Torrent::with(['category', 'subcategory'])->where('name', 'LIKE', "%{$search}%")
                ->orWhere('uploader', 'LIKE', "%{$search}%")
                ->orderByDesc('approved_at')
                ->paginate(10, ['*'], 'page', $page);
        } else {
            //$torrents['data'] = Torrent::all();
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

    public function getMovieLibraryData(Request $request)
    {
        $page = $request->query('page'); // 'mostpopular'        
        $movies = MovieLibrary::with('subCategory')
            ->paginate(24, ['*'], 'page', $page);
        // Optional: add full image URL
        $movies->getCollection()->transform(function ($movie) {
            $movie->background_url = $movie->imag_url
                ? url($movie->imag_url) // full path
                : null;
            return $movie;
        });
        return response()->json($movies);
    }

    public function store(Request $request)
    {
        $user_name = Auth::user()->username;

        $torrentFile = $request->file('torrent_file');
        $rawData = file_get_contents($torrentFile->getRealPath());
        $torrent = Bencode::decode($rawData);

        // Get the raw bencoded "info" dictionary (important for infohash)
        $infoRaw = Bencode::encode($torrent['info']);

        // Calculate SHA-1 hash
        
        $infoHashHex    = sha1($infoRaw);         // hex form (for display)

        // Torrent metadata
        $name = $torrent['info']['name'] ?? '';
        $pieceLength = $torrent['info']['piece length'] ?? 0;

        // Calculate total size
        $totalSize = 0;
        if (isset($torrent['info']['files'])) {
            // Multi-file torrent
            foreach ($torrent['info']['files'] as $file) {
                $totalSize += $file['length'];
            }
        } else {
            // Single-file torrent
            $totalSize = $torrent['info']['length'] ?? 0;
        }
        $data['file_name'] = $name;
        $total_size = number_format($totalSize / 1048576, 2) . " MB";
        $magnet = "magnet:?xt=urn:btih:$infoHashHex&dn=" . urlencode($name);
        $data['file_name'] = $name;
        
        $slug = Str::slug($request->title);
        $torrent = new Torrent();
        $torrent->name = $request->title ? $request->title : '';
        $torrent->slug = $slug ? $slug : '';
        $torrent->description = $request->description ? $request->description : '';;
        $torrent->category_id = $request->category;
        $torrent->subcategory_id = $request->subcategory;
        $torrent->magnet_link = $magnet;
        $torrent->info_hash = $infoHashHex;
        $torrent->size_formatted = $total_size;
        $torrent->seeders = 0;
        $torrent->leechers = 0;
        $torrent->approved_at = date("Y-m-d H:i:s");
        $torrent->uploader = "/user/{$user_name}/";
        $torrent->save();

        $category = Category::find($request->category);
        $subcategory = SubCategory::find($request->subcategory);
        $torrent_detail = new TorrentDetail();
        $torrent_detail->torrent_id =  $torrent->id;
        $torrent_detail->full_description =  $request->description;
        $torrent_detail->language =  $request->language;
        $torrent_detail->seeders =  0;
        $torrent_detail->leechers =  0;
        $torrent_detail->magnet_link =  $magnet;
        $torrent_detail->infohash =  $infoHashHex;
        $torrent_detail->description =  $request->description;
        $torrent_detail->category = $category->name;
        $torrent_detail->type =  $subcategory->name;
        $torrent_detail->save();
        return response()->json([
            'success' => true,
            'message' => 'Torrent uploaded successfully',
            'torrent' => $torrent
        ]);
        
    }

    public function getCategory(Request $request){
        $category['data'] = Category::with('subcategory')->get();
        return response()->json($category);
    }
}
