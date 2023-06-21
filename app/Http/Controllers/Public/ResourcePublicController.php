<?php

namespace App\Http\Controllers\Public;

use App\Constants\ResourceConstant;
use App\Http\Controllers\Controller;
use App\Http\Resources\Resource\ResourceListPublicResource;
use App\Http\Resources\Resource\ResourcePublicResource;
use App\Models\Resource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ResourcePublicController extends Controller
{
    /**
     */
    public function index($type): AnonymousResourceCollection
    {
        $resources = Resource::query()
            ->select(['id', 'name', 'phone', 'short_content', 'upload_id'])
            ->where('status', ResourceConstant::STATUS_PUBLISHED)
            ->where('type', $type)
            ->get()
        ;

        return ResourceListPublicResource::collection($resources);
    }

    public function show(Resource $resource)
    {
        if (!$resource->isActive()) {
            return $this->sendError('Resursa nu a fost gasita', 404);
        }

        return new ResourcePublicResource($resource);
    }

}
