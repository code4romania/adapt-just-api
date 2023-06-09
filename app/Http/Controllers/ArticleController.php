<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\StoreOrUpdateArticleRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Article::class);
        $articles = ArticleService::articles();

        return ArticleResource::collection($articles);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreOrUpdateArticleRequest $request): JsonResponse
    {
        $this->authorize('create', Article::class);
        ArticleService::create($request->validated());

        return $this->sendSuccess('Articolul a fost creat cu succes.');
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(StoreOrUpdateArticleRequest $request, Article $article): JsonResponse
    {
        $this->authorize('update', Article::class);
        ArticleService::update($request->validated(), $article->id);

        return $this->sendSuccess('Articolul a fost actualizat cu succes.');
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function show(Article $article): ArticleResource
    {
        $this->authorize('view', Article::class);

        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function destroy(Article $article): JsonResponse
    {
        $this->authorize('delete', Article::class);
        ArticleService::delete($article);

        return $this->sendSuccess('Articolul a fost sters cu succes.');
    }
}
