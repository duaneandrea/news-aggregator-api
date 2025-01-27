<?php

namespace App\Services;

use App\Contracts\ArticleInterface;
use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleService implements ArticleInterface
{
    public function getArticles(array $filters): LengthAwarePaginator
    {
        return Article::query()
            ->when($filters['source_id'] ?? null, fn($query) => $query->where('source_id', $filters['source_id']))
            ->when($filters['category_id'] ?? null, fn($query) => $query->where('category_id', $filters['category_id']))
            ->when($filters['date'] ?? null, fn($query) => $query->whereDate('published_at', $filters['date']))
            ->paginate(10);
    }

    public function getArticleBySlug(string $slug): Article
    {
        return Article::where('slug', $slug)->firstOrFail();
    }

    public function searchArticles(string $keyword): LengthAwarePaginator
    {
        return Article::query()
            ->where('title', 'LIKE', "%{$keyword}%")
            ->orWhere('content', 'LIKE', "%{$keyword}%")
            ->paginate(10);
    }

    public function getPersonalizedFeed(array $preferences): LengthAwarePaginator
    {
        return Article::query()
            ->when($preferences['source_id'] ?? null, fn($query) => $query->where('source_id', $preferences['source_id']))
            ->when($preferences['category_id'] ?? null, fn($query) => $query->where('category_id', $preferences['category_id']))
            ->paginate(10);
    }
}
