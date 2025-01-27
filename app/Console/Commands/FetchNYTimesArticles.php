<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Article;
use App\Models\Source;
use App\Models\Category;
use Illuminate\Support\Str;

class FetchNYTimesArticles extends Command
{
    protected $signature = 'articles:fetch-nytimes';
    protected $description = 'Fetch articles from New York Times API and save to the database';

    public function handle():void
    {
        $apiKey = config('news.ny_times_key');
        $endpoint = 'https://api.nytimes.com/svc/search/v2/articlesearch.json?q=latest+news';

        $response = Http::get($endpoint, [
            'api-key' => $apiKey,
        ]);
        $results = $response->json();
        if ($response->successful()) {
            $sourceId = Source::firstOrCreate(['name' => 'New York Times','api_endpoint' => $endpoint])->id;

            foreach ($results['response']['docs'] as $articleData) {
                $categoryId = $this->getCategoryId($articleData['section'] ?? 'Uncategorized');

                Article::updateOrCreate(
                    ['slug' => Str::slug($articleData['abstract'])],
                    [
                        'title' => $articleData['abstract'],
                        'content' => $articleData['lead_paragraph'],
                        'published_at' => Carbon::make($articleData['pub_date']),
                        'source_id' => $sourceId,
                        'category_id' => $categoryId,
                    ]
                );
            }

            $this->info('New York Times articles fetched and saved successfully!');
        } else {
            $this->error('Failed to fetch articles from New York Times.');
        }
    }

    protected function getCategoryId($name)
    {
        return Category::firstOrCreate(['name' => $name])->id;
    }
}

