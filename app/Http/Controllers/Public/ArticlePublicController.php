<?php

namespace App\Http\Controllers\Public;

use App\Constants\ArticleConstant;
use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleListPublicResource;
use App\Http\Resources\Article\ArticlePublicResource;
use App\Models\Article;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticlePublicController extends Controller
{
    /**
     */
    public function index(): AnonymousResourceCollection
    {
        $articles = Article::query()
            ->select(['id', 'name', 'short_content', 'upload_id'])
            ->where('status', ArticleConstant::STATUS_PUBLISHED)
            ->get()
        ;

        return ArticleListPublicResource::collection($articles);
    }

    public function show(Article $article)
    {
        if (!$article->isActive()) {
            return $this->sendError('Articolul nu a fost gasit', 404);
        }

        return new ArticlePublicResource($article);
    }

}
