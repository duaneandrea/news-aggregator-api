<?php

namespace App\Contracts;

use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleInterface
{
    public function getArticles(array $filters): LengthAwarePaginator;

    public function getArticleBySlug(string $slug): Article;

    public function searchArticles(string $keyword): LengthAwarePaginator;

    public function getPersonalizedFeed(array $preferences): LengthAwarePaginator;
}
