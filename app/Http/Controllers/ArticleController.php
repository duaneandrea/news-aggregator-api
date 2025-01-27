<?php

namespace App\Http\Controllers;

use App\Contracts\ArticleInterface;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected ArticleInterface $articleService;

    public function __construct(ArticleInterface $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index(Request $request)
    {
        $articles = $this->articleService->getArticles($request->only(['source_id', 'category_id', 'date']));
        return response()->json($articles);
    }

    public function show($slug)
    {
        $article = $this->articleService->getArticleBySlug($slug);
        return response()->json($article);
    }

    public function search(Request $request)
    {
        $articles = $this->articleService->searchArticles($request->input('q'));
        return response()->json($articles);
    }

    public function personalizedFeed(Request $request)
    {
        $preferences = [
            'source_id' => $request->user()->preferences->source_id ?? null,
            'category_id' => $request->user()->preferences->category_id ?? null,
        ];
        $articles = $this->articleService->getPersonalizedFeed($preferences);
        return response()->json($articles);
    }
}
