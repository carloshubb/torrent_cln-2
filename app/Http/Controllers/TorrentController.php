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
use Inertia\Inertia;
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
        }// Fetch most Category torrents based on type
        else if ($type === 'trending-week') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'Trending Torrents last 7 Days')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'trending-d-movies') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'Trending MOVIES Torrents last 24 hours')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'trending-d-tv') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'Trending TV Torrents last 24 hours')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'trending-d-games') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'Trending Games Torrents last 24 hours')
                ->paginate(10000);
        } // Fetch most Category torrents based on type
        else if ($type === 'trending-d-apps') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'Trending Applications Torrents last 24 hours')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'trending-d-music') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'Trending MUSIC Torrents last 24 hours')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'trending-d-doc') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'Trending DOCMENTRAIES Torrents last 24 hours')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'trending-d-anime') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'Trending ANIME Torrents last 24 hours')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'trending-d-other') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'Trending OTHER Torrents last 24 hours')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'trending-d-xxx') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'Trending XXX Torrents last 24 hours')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'top') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'top 100 Torrents')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'top-100-movies') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'top 100 MOVIE Torrents')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'top-100-tv') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'top 100 TV Torrents')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'top-100-games') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'top 100 GAME Torrents')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'top-100-apps') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'top 100 APPS Torrents')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'top-100-music') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'top 100 MUSIC Torrents')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'top-100-doc') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'top 100 DOCUMENTARY Torrents')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'top-100-anime') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'top 100 ANIME Torrents')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'top-100-other') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'top 100 OTHER Torrents')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
        else if ($type === 'top-100-xxx') {
            $torrents['data'] = PopularTorrent::with('subcategory')->where('category_title', 'top 100 XXX Torrents')
                ->paginate(10000);
        }// Fetch most Category torrents based on type
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
       
        $torrent = Torrent::with('detail') 
            ->where('id', $id)
            ->where('slug', $slug)
            ->firstOrFail();
       
        return response()->json($torrent);
    }


    public function option($cat=1,$page=1)
    {   
        
        $category= Category::with('subcategory')->get();
        $sel_category = SubCategory::where('id',$cat)->first()->category_id;
        $subcategories = SubCategory::where('category_id',$sel_category)->get();
        $torrents= Torrent::where('category_id',$cat)->orderBy('approved_at','desc')->paginate(10, ['*'], 'page', $page);
       // $torrent_detail = TorrentDetail::
        return Inertia::render('Option', [
            'category' => $category,
            'torrents' => $torrents,
            'subcategories' => $subcategories,
            'sel_category' => $sel_category,
            'sel_subcategory' => $cat,
           // 'torrent_detail' => $torrent_detail,
           
           
        ]);
    }
    
    public function getOptionCategory(Request $request)
    {   
        $category = $request->query('category');
        $torrents = Category::with('subcategory')->where('id',$category)->first();
       // $torrents= Torrent::where('category_id',$category)->orderBy('approved_at','desc')->get();
     return response()->json($torrents);
        
    }
     public function getOptionTorrent(Request $request)
    {   
        $category = $request->query('category');
        $page = $request->query('page');
       
      // $torrents = Category::with('subcategory')->where('id',$category)->first();
       $torrents= Torrent::with('subcategory')->where('category_id',$category)->orderBy('approved_at','desc')->paginate(10, ['*'], 'page', $page);
     return response()->json($torrents);
        
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
    public function savetorrent(Request $request)
    { 
        $torrent = $request->input('torrent');
        $updatetorrent = Torrent::where('id',$torrent['id'])->first();
        $updatetorrent->name = $torrent['name'];
        $slug = Str::slug($torrent['name']);
        $updatetorrent->slug = $slug;   
       
        $updatetorrent->seeders = $torrent['seeders'];
        $updatetorrent->leechers = $torrent['leechers'];
        $parts = explode('/', $updatetorrent->uploader); // ["", "user", "Lulloz", ""]
        $parts[2] = $torrent['detail']['uploader'];      // replace "Lulloz"
        $updatetorrent->uploader = implode('/', $parts);
       // $updatetorrent->uploader?.split('/')[2] = $torrent['detail']['uploader'];
        
        $torrent_detail = TorrentDetail::where('id',$torrent['detail']['id'])->first();
        //dd($torrent['detail']['full_description']);
        $torrent_detail->full_description = $torrent['detail']['full_description'];
        $torrent_detail->uploader = $torrent['detail']['uploader'];
       



        $updatetorrent->save();
        $torrent_detail->save();
        //dd( $updatetorrent);
        
    }

    public function getCategory(Request $request){
        $category['data'] = Category::with('subcategory')->get();
        // dd("----------->",$category['data']);
        return response()->json($category);
    }

    public function uploads(){
        if(!Auth::user()) redirect('/');
        $username = Auth::user()->username;        
        $uploads = Torrent::with(['subcategory','detail'])->where('uploader', "/user/$username/")->latest()->get();        
        return Inertia::render('TorrentUploads', [
            'uploads' => $uploads
        ]);
    }
    public function movie($id,$title){
        $keyword = explode("-",$title)[0];     
        $torrents = Torrent::with(['subcategory','detail'])
                            ->where('name','LIKE',"%$keyword%")
                            ->latest()
                            ->get();        
        return Inertia::render('TorrentMovie', [
            'torrents' => $torrents
        ]);
    }

    public function delete(Request $request)
    {
        //dd(456789);    
       
        $request->validate([
            'id' => 'required|integer|exists:torrents,id',
        ]);
      
        $torrent = Torrent::find($request->id);
         
       
        if ($torrent) {
            $torrent->delete();
            return response()->json([
                'success' => true,
                'message' => 'Torrent deleted successfully'
               
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Torrent not found',
        ], 404);
    }

    public function edit($id= null){
        if($id != null)
        $torrent = Torrent::with('detail')->where('id',$id)->first();
      
        else $torrent = null; 
         
        return Inertia::render('Edit', [
            'torrent' => $torrent
        ]);
    }
}
