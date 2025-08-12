<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Support\Facades\Log;
use App\Models\Torrent;
use App\Models\MovieLibrary;
use DateTime;

class FetchMovieLibrary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-movie-library';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $httpClient = HttpClient::create();

        $movies = [];
        $page = 1;
        while ($page < 151) {
            $movies = [];
            $url = "https://1337x.to/movie-library/{$page}/";
            $response = $httpClient->request('GET', $url);
            $html = $response->getContent();
            $crawler = new Crawler($html);
            $rows = $crawler->filter('ul.clearfix li');
            $rows->each(function (Crawler $row, $i) use (&$movies) {
                try {
                    $movie = [];
                    $img = $row->filter('a img')->attr('data-original');
                    $width = $row->filter('a span.rating-wrap i')->attr('style');
                    $info_url = $row->filter('h3 a')->attr('href');
                    $info = $row->filter('h3 a')->text();
                    $category = $row->filter('div.category')->html();
                    $content = $row->filter('p')->text();
                    $movie['img_url'] = $img ? $img : null;
                    $movie['rate'] = $width ? $width : null;
                    $movie['info_url'] = $info_url ? $info_url : null;
                    $movie['info_title'] = $info ? $info : null;
                    $movie['category'] = $category ? $category : null;
                    $movie['content'] = $content ? $content : null;
                    $movies[] = $movie;
                } catch (\Exception $e) {
                    Log::warning("Error parsing torrent row {$i}: " . $e->getMessage());
                }
            });
            $this->saveMovies($movies);
            $page++;
            sleep(0.5);
        }
        
       
    }

    private function saveMovies(array $movies): int
    {
        $savedCount = 0;

        foreach ($movies as $movie) {
            try {
                // Validate required fields before processing
                if (empty($movie['img_url']) || empty($movie['info_url'])) {
                    $this->warn("Skipping torrent - missing required fields");
                    continue;
                }
                // Map the scraper data to the proper format using the model method
                $movielibrary = MovieLibrary::where('img_url',$movie['img_url'])->first();
                if($movielibrary == null)  $movielibrary = new MovieLibrary();               
                $movielibrary->img_url = $movie['img_url'];
                $movielibrary->rate = $movie['rate'];
                $movielibrary->info_url = $movie['info_url'];
                $movielibrary->info_title = $movie['info_title'];
                $movielibrary->category = $movie['category'];
                $movielibrary->content = $movie['content'];               
                $movielibrary->save();
            } catch (\Illuminate\Database\QueryException $e) {
                Log::error("Database error saving movie: " . $e->getMessage(), [
                    'movie_data' => $movie,
                    'sql_error' => $e->getMessage()
                ]);
            } catch (\Exception $e) {
                Log::error("Failed to save movie: " . $e->getMessage(), [
                    'movie_data' => $movie,
                    'exception' => $e->getTraceAsString()
                ]);
            }
        }

        return $savedCount;
    }
}
