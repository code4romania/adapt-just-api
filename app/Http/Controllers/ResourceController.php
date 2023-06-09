<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\StoreOrUpdateArticleRequest;
use App\Http\Requests\Resource\StoreOrUpdateResourceRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Resource\ResourceResource;
use App\Models\Article;
use App\Models\Resource;
use App\Services\ArticleService;
use App\Services\ResourceService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ResourceController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Resource::class);
        $articles = ResourceService::resources();

        return ArticleResource::collection($articles);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreOrUpdateResourceRequest $request): JsonResponse
    {
        $this->authorize('create', Resource::class);
        ResourceService::create($request->validated());

        return $this->sendSuccess('Resursa a fost creata cu succes.');
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(StoreOrUpdateResourceRequest $request, Resource $resource): JsonResponse
    {
        $this->authorize('update', Resource::class);
        ResourceService::update($request->validated(), $resource->id);

        return $this->sendSuccess('Resursa a fost actualizata cu succes.');
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function show(Resource $resource): ResourceResource
    {
        $this->authorize('view', Resource::class);

        return new ResourceResource($resource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function destroy(Resource $resource): JsonResponse
    {
        $this->authorize('delete', Resource::class);
        ResourceResource::delete($resource);

        return $this->sendSuccess('Resoursa a fost stersa cu succes.');
    }
}
