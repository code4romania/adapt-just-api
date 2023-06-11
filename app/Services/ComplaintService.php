<?php

namespace App\Services;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\QueryBuilder;

class ComplaintService
{
    public static function complaints($perPage = 10): LengthAwarePaginator
    {
        return QueryBuilder::for(Complaint::class)
            ->allowedSorts(['id', 'created_at', 'name', 'city'])
            ->allowedFilters([])
            ->paginate($perPage);
    }

    public static function create($data): Model|Builder
    {
        $complaint = Complaint::query()->create($data);
        $uploads = Arr::get($data,'uploads', []);
        $complaint->uploads()->sync($uploads);

        return $complaint;
    }

    public static function update($data, $id): Model|Builder
    {
        $complaint = Complaint::find($id);
        $complaint->update($data);

        return $complaint;
    }

    public static function delete(Complaint $complaint): ?bool
    {
        return $complaint->delete();
    }
}
