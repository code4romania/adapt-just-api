<?php

namespace App\Services;

use App\Constants\ResourceConstant;
use App\Models\Resource;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\QueryBuilder;

class ResourceService
{
    public static function resources($perPage = 10): LengthAwarePaginator
    {
        return QueryBuilder::for(Resource::class)
            ->allowedSorts(['id', 'name', 'status', 'published_at'])
            ->allowedFilters([
                'name', 'status'
            ])
            ->paginate($perPage);
    }

    public static function create($data): Model|Builder
    {
        $data['published_at'] = Arr::get($data,'status') == ResourceConstant::STATUS_DRAFT ? null : Carbon::now();
        return Resource::create($data);
    }

    public static function update($data, $id): Model|Builder
    {
        $data['published_at'] = Arr::get($data,'status') == ResourceConstant::STATUS_DRAFT ? null : Carbon::now();
        $resource = Resource::find($id);
        $resource->update($data);

        return $resource;
    }


    public static function delete(Resource $resource): ?bool
    {
        return $resource->delete();
    }

}
