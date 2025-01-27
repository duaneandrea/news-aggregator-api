<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected ArticleService $articleService;

    public function __construct(ArticleService $articleService)
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
        $user = $request->user();

        if ($user->userPreferences->isEmpty()) {
            return response()->json([
                'message' => 'No preferences found for this user.',
            ], 404);
        }

        $preferences = [
            'source_id' => $user->userPreferences->first()->source_id,
            'category_id' => $user->userPreferences->first()->category_id,
        ];

        $articles = $this->articleService->getPersonalizedFeed($preferences);
        return response()->json($articles);
    }
}
