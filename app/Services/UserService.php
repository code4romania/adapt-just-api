<?php

namespace App\Services;

use App\Events\User\UserCreatedEvent;
use App\Events\UserCreatedEvent;
use App\Filters\DateBetweenFilter;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserService
{
    public static function users($perPage = 10): LengthAwarePaginator
    {
        return QueryBuilder::for(User::class)
            ->allowedSorts(['id', 'first_name', 'last_name', 'email', 'active', 'created_at', 'updated_at'])
            ->allowedFilters([
                'first_name', 'last_name', 'email', 'active',
                AllowedFilter::exact('id'),
                AllowedFilter::custom('created_at', new DateBetweenFilter),
                AllowedFilter::custom('updated_at', new DateBetweenFilter),
            ])
            ->paginate($perPage);
    }

    public static function create($userData): Model|Builder
    {
        $user = User::query()->create($userData);
        event(new UserCreatedEvent($user));

        return $user;
    }

    public static function delete(User $user): ?bool
    {
        return $user->delete();
    }
}
