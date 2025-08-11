<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Support\Facades\Log;
use App\Models\Torrent;
use App\Models\PopularTorrent;
use DateTime;

class FectchExternalHomeDataDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fectch-external-home-data-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $httpClient = HttpClient::create();        
        $torrents = [];
        $url = "https://1337x.to/home/";
        $response = $httpClient->request('GET', $url);
        $html = $response->getContent();
        $crawler = new Crawler($html);
        $rows = $crawler->filter('.featured-list');       
        $rows->each(function (Crawler $row, $i) use (&$torrents) {
            try {
                $torrent = [];
                $category_title = $row->filter('strong')->text();
                PopularTorrent::where('category_title',$category_title)->delete();
                $columns = $row->filter('div.table-list-wrap table > tbody > tr');
                $columns->each(function (Crawler $item, $ii) use (&$torrents,$category_title) {
                    $this->info("Scraped page {$ii}");
                    $torrent = $this->extractTorrentData($item);   
                    $torrent['category_title'] =  $category_title;                
                    $torrents[] = $torrent;
                });
                //
                if (!empty($torrent['name'])) {
                  
                    $torrents[] = $torrent;
                }
               
                
                
            } catch (\Exception $e) {
                Log::warning("Error parsing torrent row {$i}: " . $e->getMessage());
            }
        });
       
        $this->saveTorrent($torrents);
        sleep(0.5);
        $this->info("Scraping Bonds List complete.");
        // to get price and yield of the bonds, we need to scrape the bond page



        $this->info("All bonds updated with price and yield.");
    }
    private function convertTimeString($timeStr)
    {
        $timeStr = trim($timeStr);
        $currentYear = date("Y");
        $currentMonth = date("m");
        $currentDay = date("d");

        // Case 1: Only time (e.g., "8:44am") → assume today
        if (preg_match('/^\d{1,2}:\d{2}(am|pm)$/i', $timeStr)) {
            $dateTime = DateTime::createFromFormat("Y-m-d g:ia", "$currentYear-$currentMonth-$currentDay $timeStr");
        }
        // Case 2: Time + Month + Day (e.g., "5pm Aug. 7th")
        else {
            // Remove "th", "st", "nd", "rd"
            $timeStr = preg_replace('/(\d+)(st|nd|rd|th)/i', '$1', $timeStr);
            // Ensure consistent month format
            $timeStr = str_replace('.', '', $timeStr);
            $dateTime = DateTime::createFromFormat("ga M j Y", "$timeStr $currentYear");
            if (!$dateTime) {
                $dateTime = DateTime::createFromFormat("g:ia M j Y", "$timeStr $currentYear");
            }
        }

        return $dateTime ? $dateTime->format("Y-m-d H:i:s") : null;
    }

    private function saveTorrent(array $torrents): int
    {
        $savedCount = 0;

        foreach ($torrents as $torrentData) {
            try {
                // Validate required fields before processing
                if (empty($torrentData['name']) || empty($torrentData['sub_category_id'])) {
                    $this->warn("Skipping torrent - missing required fields");
                    continue;
                }
                // Map the scraper data to the proper format using the model method
               
                $popular_torrent = new PopularTorrent();               
                $popular_torrent->sub_category_id = $torrentData['sub_category_id'];                
                $popular_torrent->torrent_link = $torrentData['torrent_link'];
                $popular_torrent->name = $torrentData['name'];
                $popular_torrent->seeders = $torrentData['seeds'];                
                $popular_torrent->category_title = $torrentData['category_title'];
                
                $popular_torrent->comments_count = $torrentData['comments_count'];
                $popular_torrent->leechers = $torrentData['leeches'];
                $popular_torrent->approved_at = $torrentData['date_uploaded'];
                $popular_torrent->size_formatted = $torrentData['size'];
                $popular_torrent->uploader = $torrentData['uploader'];
                $popular_torrent->save();
                
            } catch (\Illuminate\Database\QueryException $e) {
                Log::error("Database error saving torrent: " . $e->getMessage(), [
                    'torrent_data' => $torrentData,
                    'sql_error' => $e->getMessage()
                ]);
            } catch (\Exception $e) {
                Log::error("Failed to save torrent: " . $e->getMessage(), [
                    'torrent_data' => $torrentData,
                    'exception' => $e->getTraceAsString()
                ]);
            }
        }

        return $savedCount;
    }

    private function extractTorrentData(Crawler $columns)
    {
        
        $suburl = $columns->filter('td.coll-1.name a')->count() > 0 ? $columns->filter('td.coll-1.name a')->eq(0)->attr('href') : null;
        if ($suburl) {
            $tmp_list = explode("/", $suburl)[2];
            $torrent['sub_category_id'] = $tmp_list ?  $tmp_list : null;
        } else {
            $torrent['sub_category_id'] = null;
        }
        $this->info($suburl);
        $suburl = $columns->filter('td.coll-1.name a')->count() > 0 ? $columns->filter('td.coll-1.name a')->eq(0)->attr('href') : null;
        $torrent['comments_count'] = $columns->filter('span.comments')->count() > 0 ? trim($columns->filter('span.comments')->text()) : null;
        $torrent['name'] = $columns->filter('td.coll-1.name a')->eq(1)->count() > 0 ? $columns->filter('td.coll-1.name a')->eq(1)->text() : null;
        $torrent['seeds'] = $columns->filter('td.coll-2.seeds')->count() > 0 ? $columns->filter('td.coll-2.seeds')->text() : null;
        $torrent['leeches'] = $columns->filter('td.coll-3.leeches')->count() > 0 ? $columns->filter('td.coll-3.leeches')->text() : null;
        $date = $columns->filter('td.coll-date')->count() > 0 ? $columns->filter('td.coll-date')->text() : null;
        $torrent['date_uploaded'] = $this->convertTimeString($date);
        $torrent['size'] = $columns->filter('td.coll-4.size.mob-uploader')->count() > 0 ? trim(explode("\n", $columns->filter('td.coll-4.size.mob-uploader')->text())[0]) : null;
        $uploader = $columns->filter('td.coll-5.uploader a')->count() > 0 ? $columns->filter('td.coll-5.uploader a')->text() : null;
        $uploader_link = $columns->filter('td.coll-5.uploader a')->count() > 0 ? $columns->filter('td.coll-5.uploader a')->attr('href') : null;
        if ($uploader_link) $torrent['uploader'] = $uploader_link;
        else $torrent['uploader'] = $uploader;
        $torrentLink = Torrent::where('name',$torrent['name'])->where('sub_category_id',$torrent['sub_category_id'])->first();
        $torrent['torrent_link'] = $torrentLink  ? $torrentLink->torrent_link  : null;
        
        return $torrent;
    }

   
    
   
    
   

    

   

   
    

   

   

   
}
