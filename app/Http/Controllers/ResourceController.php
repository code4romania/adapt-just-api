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
use App\Services\UploadService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;

class ResourceController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Resource::class);
        $resources = ResourceService::resources();

        return ResourceResource::collection($resources);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreOrUpdateResourceRequest $request): JsonResponse
    {
        $this->authorize('create', Resource::class);
        $inputs = $request->validated();
        if( !empty($inputs['content']) ) {
            $inputs['content'] = UploadService::parseHtmlContent(Arr::get($inputs, 'content', ''));
        }

        ResourceService::create($inputs);

        return $this->sendSuccess('Resursa a fost creata cu succes.');
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(StoreOrUpdateResourceRequest $request, Resource $resource): JsonResponse
    {
        $this->authorize('update', Resource::class);
        $inputs = $request->validated();
        if( !empty($inputs['content']) ) {
            $inputs['content'] = UploadService::parseHtmlContent(Arr::get($inputs, 'content', ''));
        }
        ResourceService::update($inputs, $resource->id);

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
