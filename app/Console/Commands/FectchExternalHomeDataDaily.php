<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Support\Facades\Log;
use App\Models\Torrent;
use App\Models\TorrentDetail;
use App\Models\TorrentScreenshot;
use App\Models\TorrentMediaInfo;
use App\Models\Category;
use App\Models\User;
use App\Models\PopularTorrent;
use App\Models\HomeImageList;
use App\Models\SubCategory;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
class FectchExternalHomeDataDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-external-home-data-daily';

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
                PopularTorrent::where('category_title', $category_title)->delete();
                $columns = $row->filter('div.table-list-wrap table > tbody > tr');
                $columns->each(function (Crawler $item, $ii) use (&$torrents, $category_title) {
                    $torrent = $this->extractTorrentData($item);
                    $torrent['category_title'] =  $category_title;
                    $torrents[] = $torrent;
                });
                //
                 Log::info("torrent count: " . $i);
                if (!empty($torrent['name'])) {

                    $torrents[] = $torrent;
                }
            } catch (\Exception $e) {
                Log::warning("Error parsing torrent row 1 {$i}: " . $e->getMessage());
            }
        });
        //dd($torrents);
       
        $this->saveTorrent($torrents);
        sleep(0.5);
        // to get price and yield of the bonds, we need to scrape the bond page

        //get image of home page
        $images_tag = $crawler->filter('div li a');
        $image_list = [];
        $images_tag->each(function (Crawler $row, $i) use (&$image_list) {
            try {
                $data['image'] = $row->filter('img')->attr('src');
                $data['title'] = $row->attr('title');
                $data['quality'] = $row->filter('span')->text();
                $data['link_url'] = $row->count() > 0
                    ? $row->attr('href')
                    : null;
                
                $image_list[] = $data;
            } catch (\Exception $e) {
                Log::warning("Error parsing torrent row 2 {$i}: " . $e->getMessage());
            }
        });
        $this->saveHomeImageList($image_list);
    }
    private function convertTimeString($timeStr)
    {
        $timeStr = trim($timeStr);

        $currentYear  = date("Y");
        $currentMonth = date("n");
        $currentDay   = date("j");

        // Remove suffixes (st, nd, rd, th) and dots after months
        $timeStr = preg_replace('/(\d+)(st|nd|rd|th)/i', '$1', $timeStr);
        $timeStr = str_replace('.', '', $timeStr);

        $dateTime = null;

        // Case 1: Only time (e.g., "7:36am")
        if (preg_match('/^\d{1,2}:\d{2}(am|pm)$/i', $timeStr)) {
            $dateTime = DateTime::createFromFormat(
                "Y-n-j g:ia",
                "$currentYear-$currentMonth-$currentDay $timeStr"
            );
        }
        // Case 2: Only hour + am/pm + Month + Day (e.g., "2am Aug 13")
        elseif (preg_match('/^\d{1,2}(am|pm)\s+[A-Za-z]+\s+\d{1,2}$/i', $timeStr)) {
            $dateTime = DateTime::createFromFormat(
                "ga M j Y",
                "$timeStr $currentYear"
            );
        }
        // Case 3: Hour:minute + am/pm + Month + Day (e.g., "11:49am Aug 12")
        elseif (preg_match('/^\d{1,2}:\d{2}(am|pm)\s+[A-Za-z]+\s+\d{1,2}$/i', $timeStr)) {
            $dateTime = DateTime::createFromFormat(
                "g:ia M j Y",
                "$timeStr $currentYear"
            );
        }

        return $dateTime ? $dateTime->format("Y-m-d H:i:s") : null;
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
                $popular_torrent->comments_count = $torrentData['comments_count'] ? $torrentData['comments_count'] : 0;
                $popular_torrent->leechers = $torrentData['leeches'];
                $popular_torrent->approved_at = $torrentData['date_uploaded'];
                $popular_torrent->size_formatted = $torrentData['size'];
                $popular_torrent->uploader = $torrentData['uploader'];
              

                $detail_url = $this->buildDetailUrl($torrentData['torrent_link']);
                $httpClient = HttpClient::create();
                $response = $httpClient->request('GET', $detail_url);
                $html = $response->getContent();
                $detailData = $this->parseDetailPage($html);
                //save to torrent table
                $category = SubCategory::where('id', $popular_torrent->subcategory_id)->first()->category_id;
                $slug = explode("/", $popular_torrent->torrent_link)[3];
                $torrent = Torrent::where('subcategory_id', $popular_torrent->subcategory_id)->where('slug', $slug)->first();
                if ($torrent == null) {
                    $torrent = new Torrent();
                    $torrent->slug = strtolower($slug);
                    $torrent->name = $popular_torrent->name;
                    $torrent->category_id = $category;
                    $torrent->subcategory_id = $popular_torrent->subcategory_id;
                    $torrent->uploader = $popular_torrent->uploader;
                    $torrent->size_formatted = $popular_torrent->size_formatted;
                    $torrent->approved_at = $popular_torrent->approved_at;
                    $torrent->seeders = $popular_torrent->seeders;
                    $torrent->leechers = $popular_torrent->leechers;
                    $torrent->comments_count = $popular_torrent->comments_count;
                    $torrent->save();
                }
                $torrentLink_pattern = explode("/",$popular_torrent->torrent_link);
                
                $popular_torrent->torrent_link = strtolower("/$torrentLink_pattern[1]/$torrent->id/$torrentLink_pattern[3]");
                $popular_torrent->save();
                $this->saveTorrentDetails($torrent, $detailData);
                $this->userInfoPage($torrent->uploader);
                $this->info(date("Y-m-d H:i:s")." $savedCount =>Added or Saved Home Torrent");
                sleep(0.1);
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
            $savedCount++;
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
        $torrentLink = $columns->filter('td.coll-1.name a')->count() > 0 ? $columns->filter('td.coll-1.name a')->eq(1)->attr('href') : null;
        $torrent['torrent_link'] = $torrentLink  ? $torrentLink  : null;

        return $torrent;
    }

    private function saveHomeImageList($image_list)
    {
        HomeImageList::truncate();
        foreach ($image_list as $image) {
            try {
                // Validate required fields before processing
                if (!$image) {
                    $this->warn("Skipping torrent - missing required fields");
                    continue;
                }
                // Map the scraper data to the proper format using the model method
                $detail_url = $this->buildDetailUrl($image['link_url']);
                $httpClient = HttpClient::create();
                $response = $httpClient->request('GET', $detail_url);
                $html = $response->getContent();
                $detailData = $this->parseDetailPage($html);
                //save to torrent table
               
                $category = Category::where('name', $detailData['category'])->first()->id;
                $subcategory = SubCategory::where('category_id',$category)->where('name', $detailData['type'])->first()->id;
                $slug = explode("/", $image['link_url'])[3];
                $torrent = Torrent::where('subcategory_id', $subcategory)->where('slug', $slug)->first();
                if ($torrent == null) {
                    $torrent = new Torrent();
                    $torrent->slug = strtolower($slug);
                    $torrent->name = $image['title'];
                    $torrent->category_id = $category;
                    $torrent->subcategory_id = $subcategory;
                    $torrent->uploader = "/user/{$detailData['uploadedby']}";
                    $torrent->size_formatted = $detailData['totalsize'];
                    $torrent->approved_at = $detailData['dateuploaded'];
                    $torrent->seeders = $detailData['seeders'];
                    $torrent->leechers = $detailData['leechers'];
                    $torrent->comments_count = 0;
                    $torrent->save();

                    $this->saveTorrentDetails($torrent,$detailData);
                }
                $torrentLink_pattern = explode("/",$image['link_url']);
                
                $torrent_link = strtolower("/$torrentLink_pattern[1]/$torrent->id/$torrentLink_pattern[3]");
                
                HomeImageList::create([
                    'title' => $image['title'],
                    'image_url' => $image['image'],
                    'quality' => $image['quality'],
                    'link' => $torrent_link ,
                    'order' => 1,
                    'is_active' => true,
                ]);
                
            } catch (\Illuminate\Database\QueryException $e) {
                Log::error("Database error saving image: " . $e->getMessage());
            } catch (\Exception $e) {
                Log::error("Failed to save torrent: " . $e->getMessage());
            }
        }
    }

    private function userInfoPage($userurl)
    {
        $username = explode('/', $userurl)[2];
        $user = User::where('username', $username)->first();
        if ($user) return;
        $user = new User();
        $httpClient = HttpClient::create();
        $url = "https://1337x.to{$userurl}";
        //$url = "https://1337x.to/user/Saturn5x/";
        $response = $httpClient->request('GET', $url);
        $html = $response->getContent();
        $crawler = new Crawler($html);
        $data['userrank'] = null;
        $data['privacy'] = null;
        $data['gender'] = null;
        $data['country'] = null;
        $data['age'] = null;
        $data['joindate'] = null;
        $rows_list = $crawler->filter('.box-info-detail li');
        $user->username = $username;
        $rows_list->each(function (Crawler $row, $i) use (&$data) {
            try {
                $row->each(function (Crawler $item, $ii) use (&$data) {
                    if ($item->filter('strong')->count() > 0) {
                        $fieldName = strtolower(
                            preg_replace('/\s+/', '', $item->filter('strong')->text())
                        );
                    } else {
                        $fieldName = '';
                    }

                    $fieldValue = $item->filter('span')->text();
                    $data[$fieldName] = $fieldValue;
                });
                //
                if (!empty($torrent['name'])) {
                }
            } catch (\Exception $e) {
                Log::warning("Error parsing torrent row {$i}: " . $e->getMessage());
            }
        });
        $user->rank = $data['userrank'] ? $data['userrank'] : null;
        $user->privacy = $data['privacy'] ? $data['privacy'] : null;
        $user->gender = $data['gender'] ? $data['gender'] : null;
        $user->country = $data['country'] ? $data['country'] : null;
        if ($data['age']) {
            $yearOfBirth = date('Y') - $data['age'];
            $birthday = ($yearOfBirth) . "-01-01 00:00:00";
            $user->birthday = $birthday;
        }
        $user->joindate = $data['joindate'] ? $this->normalizeJoinDate($data['joindate']) : null;
        $user->password = Hash::make('123456');
        $user->email = "$username@example.com";
        $user->save();
    }
    private function parseDetailPage($html)
    {


        $crawler = new Crawler($html);
        $data = [];
        $rows_list = $crawler->filter('ul.list');

        $rows_list->each(function (Crawler $row, $i) use (&$data) {
            try {
                $torrent_detail = [];
                $columns = $row->filter('li');
                $columns->each(function (Crawler $item, $ii) use (&$data) {
                    if ($item->filter('strong')->count() > 0) {
                        $fieldName = strtolower(
                            preg_replace('/\s+/', '', $item->filter('strong')->text())
                        );
                    } else {
                        $fieldName = '';
                    }

                    $fieldValue = $item->filter('span')->text();
                    $data[$fieldName] = $fieldValue;
                });
                //
                if (!empty($torrent['name'])) {
                }
            } catch (\Exception $e) {
                Log::warning("Error parsing torrent row {$i}: " . $e->getMessage());
            }
        });

        $rows_magnet = $crawler->filter('a[href^="magnet:"]');
        $data['magnet_link'] = $rows_magnet->count() > 0 ? $rows_magnet->attr('href') : null;
        $infohash = $crawler->filter('div.infohash-box p span')->text();
        $data['infohash'] = $infohash ? $infohash : null;
        $baseUrl = "";
        $description = $crawler->filter('div#description')->each(function ($node) use ($baseUrl) {
            $node->filter('img')->each(function ($img) use ($baseUrl) {
                $dataOriginal = $img->attr('data-original');

                if ($dataOriginal) {
                    // Remove escaped quotes like \&quot;
                    $cleaned = str_replace('\&quot;', '', $dataOriginal);

                    // Replace escaped slashes \/ with /
                    $cleaned = str_replace('\/', '/', $cleaned);

                    // Decode any HTML entities if needed
                    $cleaned = html_entity_decode($cleaned);

                    $src = $cleaned;
                } else {
                    $src = $img->attr('src');
                }

                // Make URL absolute if relative
                if (strpos($src, 'http') !== 0) {
                    $src = rtrim($baseUrl, '/') . '/' . ltrim($src, '/');
                }

                $img->getNode(0)->setAttribute('src', $src);
            });

            return $node->html();
        });
        if ($description) {
            $description = str_replace("\n", '', $description[0]);
        } else {
            $description = null;
        }

        $data['description'] = $description ? $description : null;
        $files = $crawler->filter('div#files')->html();
        $data['files'] = $files ? $files : null;
        $comments = $crawler->filter('div#comments')->html();
        $data['comments'] = $comments ? $comments : null;
        $trackerlist = $crawler->filter('div#tracker-list')->html();
        $data['trackerlist'] = $trackerlist ? $trackerlist : null;


        $data['full_description'] = $this->extractDescription($crawler);
        $data['cover_image'] = $this->extractCoverImage($crawler);
        $data['screenshots'] = $this->extractScreenshots($crawler);

        // Movie/Media specific information
        $data['imdb_rating'] = $this->extractImdbRating($crawler);
        $data['genre'] = $this->extractGenre($crawler);
        $data['runtime'] = $this->extractRuntime($crawler);
        $data['director'] = $this->extractDirector($crawler);
        $data['cast'] = $this->extractCast($crawler);
        $data['release_date'] = $this->extractReleaseDate($crawler);

        // Technical information
        $data['quality'] = $this->extractQuality($crawler);
        $data['format'] = $this->extractFormat($crawler);
        $data['source'] = $this->extractSource($crawler);
        $data['encoder'] = $this->extractEncoder($crawler);
        $data['audio_language'] = $this->extractAudioLanguage($crawler);
        $data['subtitle_language'] = $this->extractSubtitleLanguage($crawler);
        // File information
        $data['total_files'] = $this->extractFileCount($crawler);
        $data['nfo_content'] = $this->extractNfoContent($crawler);
        $data['has_sample'] = $this->checkHasSample($crawler);
        $data['media_info'] = $this->extractMediaInfo($crawler);
        
        // Uploader information
        $data['uploader_status'] = $this->extractUploaderStatus($crawler);
        return $data;
        return array_filter($data, function ($value) {
            return $value !== null && $value !== '';
        });
    }
    private function buildDetailUrl($torrentLink)
    {
        // If it's already a full URL, return as is
        if (str_starts_with($torrentLink, 'http')) {
            return $torrentLink;
        }

        // If it's a relative path, build full URL
        return 'https://1337x.to' . $torrentLink;
    }
    private function extractDescription($crawler)
    {
        try {
            // Try multiple selectors for description
            $selectors = [
                '.box-info-detail .torrent-detail-info',
                '.torrent-detail-page .box-info .torrent-category-detail',
                '#description',
                '.description',
                '.box-info p'
            ];

            foreach ($selectors as $selector) {
                $element = $crawler->filter($selector);
                if ($element->count() > 0) {
                    return trim($element->text());
                }
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
    private function extractCoverImage($crawler)
    {
        try {
            $selectors = [
                '.torrent-image img',
                '.box-info img.torrent-image',
                '.poster img',
                '.movie-poster img'
            ];

            foreach ($selectors as $selector) {
                $element = $crawler->filter($selector);
                if ($element->count() > 0) {
                    return $element->attr('src');
                }
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractScreenshots($crawler)
    {
        try {
            $screenshots = [];

            $crawler->filter('.screenshots img, .screenshot img, .torrent-image img')->each(
                function (Crawler $img) use (&$screenshots) {
                    $src = $img->attr('src');
                    if ($src && !in_array($src, $screenshots)) {
                        $screenshots[] = $src;
                    }
                }
            );

            return !empty($screenshots) ? $screenshots : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractImdbRating($crawler)
    {
        try {
            $rating = $crawler->filter('.imdb-rating, .rating')->first();
            if ($rating->count() > 0) {
                $ratingText = $rating->text();
                preg_match('/(\d+\.?\d*)/', $ratingText, $matches);
                return isset($matches[1]) ? (float) $matches[1] : null;
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractGenre($crawler)
    {
        try {
            return $this->extractInfoField($crawler, ['Genre', 'Category', 'Type']);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractLanguage($crawler)
    {
        try {
            return $this->extractInfoField($crawler, ['Language', 'Audio Language']);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractRuntime($crawler)
    {
        try {
            return $this->extractInfoField($crawler, ['Runtime', 'Duration']);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractDirector($crawler)
    {
        try {
            return $this->extractInfoField($crawler, ['Director', 'Directed by']);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractCast($crawler)
    {
        try {
            return $this->extractInfoField($crawler, ['Cast', 'Starring', 'Stars']);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractReleaseDate($crawler)
    {
        try {
            $dateString = $this->extractInfoField($crawler, ['Release Date', 'Year', 'Released']);
            if ($dateString) {
                try {
                    return Carbon::parse($dateString)->format('Y-m-d');
                } catch (\Exception $e) {
                    return null;
                }
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractQuality($crawler)
    {
        try {
            $quality = $this->extractInfoField($crawler, ['Quality', 'Resolution']);
            if (!$quality) {
                // Try to extract from title
                $title = $crawler->filter('h1, .title')->first();
                if ($title->count() > 0) {
                    $titleText = $title->text();
                    if (preg_match('/(720p|1080p|2160p|4K|HD|CAM|TS|HDTS)/i', $titleText, $matches)) {
                        $quality = $matches[1];
                    }
                }
            }
            return $quality;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractFormat($crawler)
    {
        try {
            return $this->extractInfoField($crawler, ['Format', 'Container', 'File Type']);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractSource($crawler)
    {
        try {
            return $this->extractInfoField($crawler, ['Source', 'Rip Type']);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractEncoder($crawler)
    {
        try {
            return $this->extractInfoField($crawler, ['Encoder', 'Encoded by', 'Release Group']);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractAudioLanguage($crawler)
    {
        try {
            return $this->extractInfoField($crawler, ['Audio Language', 'Audio']);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractSubtitleLanguage($crawler)
    {
        try {
            return $this->extractInfoField($crawler, ['Subtitle', 'Subtitles', 'Subs']);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractFileCount($crawler)
    {
        try {
            $fileList = $crawler->filter('.file-list li, .files li');
            return $fileList->count() > 0 ? $fileList->count() : 1;
        } catch (\Exception $e) {
            return 1;
        }
    }

    private function extractNfoContent($crawler)
    {
        try {
            $nfo = $crawler->filter('.nfo, .nfo-content, pre');
            return $nfo->count() > 0 ? $nfo->text() : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function checkHasSample($crawler)
    {
        try {
            $fileList = $crawler->filter('.file-list, .files')->text();
            return str_contains(strtolower($fileList), 'sample');
        } catch (\Exception $e) {
            return false;
        }
    }

    private function extractMediaInfo($crawler)
    {
        try {
            $mediaInfo = "";
            $mediaInfoSection = $crawler->filter('a[href^="https://uflix.cc"]');
            $mediaInfo = $mediaInfoSection->attr('href') ? $mediaInfoSection->attr('href') : "";
            return !empty($mediaInfo) ? $mediaInfo : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractUploaderStatus($crawler)
    {
        try {
            $uploader = $crawler->filter('.uploader, .torrent-uploader');
            if ($uploader->count() > 0) {
                $uploaderText = $uploader->text();
                if (str_contains($uploaderText, 'VIP')) return 'VIP';
                if (str_contains($uploaderText, 'Trusted')) return 'Trusted';
            }
            return 'User';
        } catch (\Exception $e) {
            return 'User';
        }
    }

    private function extractInfoField($crawler, $fieldNames)
    {
        foreach ($fieldNames as $fieldName) {
            try {
                // Try to find the field in info boxes
                $field = $crawler->filter('.box-info')->filterXPath(
                    "//text()[contains(translate(., 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '" . strtolower($fieldName) . "')]"
                );

                if ($field->count() > 0) {
                    $parent = $field->getNode(0)->parentNode;
                    $text = $parent->textContent;

                    // Extract value after the field name
                    $parts = explode(':', $text, 2);
                    if (count($parts) == 2) {
                        return trim($parts[1]);
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return null;
    }

    private function saveTorrentDetails($torrent, $detailData)
    {
        
        try {
            // Update main torrent record
            $updateData = array_intersect_key($detailData, array_flip([
                'full_description',
                'language',
                'category',
                'type',
                'lastchecked',
                'infohash',
                'magnet_link',
                'dateuploaded',
                'description',
                'files',
                'comments',
                'seeders',
                'leechers',
                'trackerlist',
                'release_date',
                'genre',
                'quality',
                'format',
                'audio_language',
                'subtitle_language',
                'encoder',
                'source',
                'imdb_rating',
                'runtime',
                'director',
                'cast',
                'cover_image',
                'total_files',
                'nfo_content',
                'has_sample',
                'uploader_status'
            ]));
            $updateData['download_count'] = $detailData['downloads'] ?? null;
            $updateData['uploader'] = $detailData['uploadedby'] ?? null;
            //dd($updateData['uploader']);
            $updateData['detail_scraped_at'] = now();
            $updateData['screenshots'] = $detailData['screenshots'] ?? null;
            if (is_array($updateData['screenshots'])) {
                $updateData['screenshots'] = json_encode($updateData['screenshots']);
            }

            $updateData['media_info'] = $detailData['media_info'] ?? null;
            if (is_array($updateData['media_info'])) {
                $updateData['media_info'] = json_encode($updateData['media_info']);
            }

            // Save or update TorrentDetail by torrent_id
            $torrentdetail = TorrentDetail::updateOrCreate(
                ['torrent_id' => $torrent->id], // match condition
                $updateData                     // data to update or insert
            );

            // Optionally also update Torrent table with relevant details
            //$torrent->update($updateData);

            // Save screenshots separately if they exist
            if (!empty($detailData['screenshots'])) {
                $this->saveScreenshots($torrent->id, $detailData['screenshots']);
            }

            // Save media info separately if it exists
            // if (!empty($detailData['media_info'])) {
            //     $this->saveMediaInfo($torrent->id, $detailData['media_info']);
            // }
        } catch (\Exception $e) {
            Log::error("saveTorrentDetails=> Failed to save torrent details", [
                
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    private function saveScreenshots($torrentId, $screenshots)
    {
        try {
            // Delete existing screenshots
            TorrentScreenshot::where('torrent_id', $torrentId)->delete();

            // Save new screenshots
            foreach ($screenshots as $index => $screenshot) {
                TorrentScreenshot::create([
                    'torrent_id' => $torrentId,
                    'image_url' => $screenshot,
                    'order' => $index + 1
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Failed to save screenshots", [
               
                'error' => $e->getMessage()
            ]);
        }
    }

    private function saveMediaInfo($torrentId, $mediaInfo)
    {
        try {
            // This would parse the media info and save structured data
            // For now, just save the raw data
            TorrentMediaInfo::updateOrCreate(
                ['torrent_id' => $torrentId, 'info_type' => 'general'],
                ['additional_info' => $mediaInfo]
            );
        } catch (\Exception $e) {
            Log::error("Failed to save media info", [
               
                'error' => $e->getMessage()
            ]);
        }
    }

    private function normalizeJoinDate(string $raw): ?string
    {
        $raw = trim(strtolower($raw));
        $now = new DateTime();

        // Handle relative time
        if (preg_match('/(\d+)\s+(minute|hour|day|week|month|year|decade|century)s?\s+ago/i', $raw, $m)) {
            $num = (int)$m[1];
            $unit = $m[2];
            $date = (clone $now)->modify("-$num $unit");
            return $date->format("Y-m-d H:i:s");
        }

        // Handle "a minute ago" / "an hour ago" / "a day ago" etc.
        if (preg_match('/\b(a|an)\s+(minute|hour|day|week|month|year|decade|century)\s+ago/i', $raw, $m)) {
            $unit = $m[2];
            $date = (clone $now)->modify("-1 $unit");
            return $date->format("Y-m-d H:i:s");
        }

        // Handle special words
        if ($raw === "today") {
            return $now->format("Y-m-d 00:00:00");
        }
        if ($raw === "yesterday") {
            return (clone $now)->modify("-1 day")->format("Y-m-d 00:00:00");
        }
        if ($raw === "just now") {
            return $now->format("Y-m-d H:i:s");
        }

        // Handle absolute date formats
        $formats = [
            "M. j, Y",
            "M j, Y",
            "F j, Y",
            "Y-m-d",
            "d M Y",
            "j M Y",
        ];
        foreach ($formats as $f) {
            $date = DateTime::createFromFormat($f, $raw);
            if ($date !== false) {
                return $date->format("Y-m-d H:i:s");
            }
        }

        // Last resort: try strtotime
        $ts = strtotime($raw);
        if ($ts !== false) {
            return date("Y-m-d H:i:s", $ts);
        }

        return null; // if nothing matched
    }
}
