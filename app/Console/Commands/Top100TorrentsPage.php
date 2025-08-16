<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Support\Facades\Log;
use App\Models\Torrent;
use App\Models\PopularTorrent;
use DateTime;

class Top100TorrentsPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:top100-torrents-page';

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
        $httpClient = HttpClient::create();
        $torrents = [];
        $urls = [
            "https://1337x.to/top-100",
            "https://1337x.to/top-100-movies",
            "https://1337x.to/top-100-television",
            "https://1337x.to/top-100-games",
            "https://1337x.to/top-100-music",
            "https://1337x.to/top-100-documentaries",
            "https://1337x.to/top-100-anime",
            "https://1337x.to/top-100-other",
            "https://1337x.to/top-100-xxx",
            "https://1337x.to/top-100-applications"
        ];
        foreach ($urls as $url) {
            $torrents = [];
            $response = $httpClient->request('GET', $url);
            $html = $response->getContent();
            $crawler = new Crawler($html);
            $rows = $crawler->filter('.featured-list');
            $rows->each(function (Crawler $row, $i) use (&$torrents) {
                try {
                    $torrent = [];
                    $category_title = $row->filter('strong')->text();
                    PopularTorrent::where('category_title', $category_title)->delete();
                    $columns = $row->filter('div.table-list-wrap table > tbody > tr');
                    $columns->each(function (Crawler $item, $ii) use (&$torrents, $category_title) {
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
            $this->info("Scraping {$url} List complete.");
        }
        // to get price and yield of the bonds, we need to scrape the bond page
        $this->info("All Top Torrent Scrapping completed.");
    }
    private function convertTimeString($timeStr)
    {
        $timeStr = trim($timeStr);
        $currentYear = date("Y");

        // Remove ordinal suffixes
        $timeStr = preg_replace('/(\d+)(st|nd|rd|th)/i', '$1', $timeStr);

        // Remove dots from months
        $timeStr = str_replace('.', '', $timeStr);

        // Fix year format like "'25" → "2025"
        $timeStr = preg_replace_callback(
            "/'(\d{2})/",
            function ($m) {
                return "20" . $m[1];
            },
            $timeStr
        );

        // If no year provided, append current year
        if (!preg_match('/\b\d{4}\b/', $timeStr)) {
            $timeStr .= " $currentYear";
        }

        $formats = [
            "M j Y",          // Jul 17 2025
            "g:ia M j Y",     // 9am Aug 1 2025
            "ga M j Y",       // 7pm Aug 2 2025
            "M j Y g:ia",     // Jul 17 2025 9:30am
            "M j Y ga",       // Jul 17 2025 9am
            "ga M j Y",       // 7pm Aug 2 2025
        ];

        foreach ($formats as $format) {
            $dateTime = DateTime::createFromFormat($format, $timeStr);
            if ($dateTime) {
                return $dateTime->format("Y-m-d H:i:s");
            }
        }

        return null; // Failed to parse
    }

    private function saveTorrent(array $torrents): int
    {
        $savedCount = 0;

        foreach ($torrents as $torrentData) {
            try {
                // Validate required fields before processing
                if (empty($torrentData['name']) || empty($torrentData['subcategory_id'])) {
                    $this->warn("Skipping torrent - missing required fields");
                    continue;
                }
                // Map the scraper data to the proper format using the model method

                $popular_torrent = new PopularTorrent();
                $popular_torrent->subcategory_id = $torrentData['subcategory_id'];
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
            $torrent['subcategory_id'] = $tmp_list ?  $tmp_list : null;
        } else {
            $torrent['subcategory_id'] = null;
        }
        $this->info($suburl);
        $suburl = $columns->filter('td.coll-1.name a')->count() > 0 ? $columns->filter('td.coll-1.name a')->eq(0)->attr('href') : null;
        $torrent['comments_count'] = $columns->filter('span.comments')->count() > 0 ? trim($columns->filter('span.comments')->text()) : null;
        $torrent['name'] = $columns->filter('td.coll-1.name a')->eq(1)->count() > 0 ? $columns->filter('td.coll-1.name a')->eq(1)->text() : null;
        $torrent['seeds'] = $columns->filter('td.coll-2.seeds')->count() > 0 ? $columns->filter('td.coll-2.seeds')->text() : null;
        $torrent['leeches'] = $columns->filter('td.coll-3.leeches')->count() > 0 ? $columns->filter('td.coll-3.leeches')->text() : null;
        $date = $columns->filter('td.coll-date')->count() > 0 ? $columns->filter('td.coll-date')->text() : null;
        $torrent['date_uploaded'] = $this->convertTimeString($date);
        $torrent['size'] = $columns->filter('td.coll-4')->count() > 0 ? trim(explode("\n", $columns->filter('td.coll-4')->text())[0]) : null;
        $size_only = "";
        if (preg_match('/([\d\.]+\s[GMK]B)/', $torrent['size'], $matches)) {
            $size_only = $matches[1];
        }
        $torrent['size'] = $size_only;
        $uploader = $columns->filter('td.coll-5 a')->count() > 0 ? $columns->filter('td.coll-5 a')->text() : null;
        $uploader_link = $columns->filter('td.coll-5 a')->count() > 0 ? $columns->filter('td.coll-5 a')->attr('href') : null;
        if ($uploader_link) $torrent['uploader'] = $uploader_link;
        else $torrent['uploader'] = $uploader;
        //$torrentLink = Torrent::where('name', $torrent['name'])->where('subcategory_id', $torrent['subcategory_id'])->first();
        $torrent['torrent_link'] = $columns->filter('td.coll-1.name a')->count() > 0 ? $columns->filter('td.coll-1.name a')->eq(1)->attr('href') : null;

        return $torrent;
    }
}
