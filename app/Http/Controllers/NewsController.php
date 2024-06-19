<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

use Illuminate\Support\Collection;


class NewsController extends Controller
{
    public function index()
    {
        $news = \DB::table('news')->get();
        return response()->json([
            'data' => $news
        ]);
    }

    public function getByCategory(string $category)
    {
        $news = \DB::table('news')->where('category', $category)->get();
        return response()->json([
            'data' => $news
        ]);
    }

    public static function getNewest(string $url, string $author)
    {
        
        $news = NewsController::getNewsAsArray($url, $author);
        \Log::info("fetch");
        foreach ($news as $item)
        {
            News::firstOrCreate([
                'title' => $item->title,
            ],
            [
                'description' => $item->description,
                'link' => $item->link,
                'image' => $item->url,
                'category' => $item->category,
                'author'    =>  $author,
                'pubDate'   =>  $item->pubDate
            ]);
        }
    }

    private static function getNewsAsArray(string $url, string $author)
    {
        $response = Http::get($url);
        $xmlContent = $response->body();
        $xml = new \SimpleXMLElement($xmlContent);

        $newsItems = [];
        foreach ($xml->channel->item as $item) {
            if ($author == 'klix')
            {
                $newsItem = new \stdClass();
                $newsItem->title = (string) $item->title;
                $newsItem->link = (string) $item->link;
                $newsItem->description = (string) $item->description;
                $newsItem->category = (string) $item->category;
                $newsItem->pubDate = (string) $item->pubDate;
                
                $itemAsString = $item->asXML();
                //preg_match('/<media:content[^>]*>(.*?)<\/media:content>/s', $itemAsString, $matches);
                preg_match('/url="(.*?)"/', $itemAsString, $matches);
                $newsItem->url = (string) $matches[1];
                
                $newsItems[] = $newsItem;
            }
            if ($author == 'vijesti.ba')
            {
                var_dump($item);
                $newsItem = new \stdClass();
                $newsItem->title = (string) $item->title;
                $newsItem->link = (string) $item->link;
                $newsItem->description = (string) $item->description;
                $newsItem->category = (string) 'Vijesti';
                $newsItem->pubDate = (string) $item->pubDate;
                $newsItem->url = (string) $item->image;;
                
                $newsItems[] = $newsItem;
            }
            // u 03:20, 50 vijesti

        }

        return $newsItems;
    }
}
