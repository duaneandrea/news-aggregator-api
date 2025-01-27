<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Article;
use App\Models\Source;
use App\Models\Category;
use Illuminate\Support\Str;

class FetchNewsApiArticles extends Command
{
    protected $signature = 'articles:fetch-newsapi';
    protected $description = 'Fetch articles from NewsAPI and save to the database';

    public function handle(): void
    {
        $apiKey = config('news.news_api_key');
        $endpoint = 'https://newsapi.org/v2/top-headlines';

        $response = Http::get($endpoint, [
            'apiKey' => $apiKey,
            'country' => 'us',
            'category' => 'technology',
        ]);

        if ($response->successful()) {
            $sourceId = Source::firstOrCreate(['name' => 'NewsAPI','api_endpoint' => $endpoint])->id;

            foreach ($response->json('articles') as $articleData) {
                $categoryId = $this->getCategoryId($articleData['category'] ?? 'Uncategorized');

                Article::updateOrCreate(
                    ['slug' => Str::slug($articleData['title'])],
                    [
                        'title' => $articleData['title'],
                        'content' => $articleData['description'] ?? $articleData['url'],
                        'published_at' => Carbon::make($articleData['publishedAt']),
                        'source_id' => $sourceId,
                        'category_id' => $categoryId,
                    ]
                );
            }

            $this->info('NewsAPI articles fetched and saved successfully!');
        } else {
            $this->error('Failed to fetch articles from NewsAPI.');
        }
    }

    protected function getCategoryId($name)
    {
        return Category::firstOrCreate(['name' => $name])->id;
    }
}

