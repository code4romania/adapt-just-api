<?php

namespace App\Services;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

class ComplaintService
{
    public static function complaints($perPage = 10): LengthAwarePaginator
    {
        return QueryBuilder::for(User::class)
            ->allowedSorts(['id', 'register_number', 'location_name'])
            ->allowedFilters([])
            ->paginate($perPage);
    }

    public static function create($data): Model|Builder
    {
        $complaint = ComplaintService::create($data);
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
