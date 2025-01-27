<?php
namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Article;
use App\Models\Source;
use App\Models\Category;
use Illuminate\Support\Str;

class FetchGuardianArticles extends Command
{
    protected $signature = 'articles:fetch-guardian';
    protected $description = 'Fetch articles from The Guardian API and save to the database';

    public function handle():void
    {
        $apiKey = config('news.guardian_api_key');
        $endpoint = 'https://content.guardianapis.com/search';

        $response = Http::get($endpoint, [
            'api-key' => $apiKey,
            'section' => 'technology',
        ]);

        if ($response->successful()) {
            $sourceId = Source::firstOrCreate(['name' => 'The Guardian','api_endpoint' => $endpoint])->id;

            foreach ($response->json('response.results') as $articleData) {
                $categoryId = $this->getCategoryId($articleData['sectionName'] ?? 'Uncategorized');

                Article::updateOrCreate(
                    ['slug' => Str::slug($articleData['webTitle'])],
                    [
                        'title' => $articleData['webTitle'],
                        'content' => $articleData['webUrl'] ?? 'Content not available',
                        'published_at' => Carbon::make($articleData['webPublicationDate']),
                        'source_id' => $sourceId,
                        'category_id' => $categoryId,
                    ]
                );
            }

            $this->info('The Guardian articles fetched and saved successfully!');
        } else {
            $this->error('Failed to fetch articles from The Guardian.');
        }
    }

    protected function getCategoryId($name)
    {
        return Category::firstOrCreate(['name' => $name])->id;
    }
}

