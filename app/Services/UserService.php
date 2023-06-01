<?php

namespace App\Services;

use App\Events\UserCreatedEvent;
use App\Filters\DateBetweenFilter;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
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
        $user = User::create($userData);
        self::syncPermissions($user, Arr::get($userData, 'permissions', []));
        event(new UserCreatedEvent($user));
        return $user;
    }

    public static function update($userData, $userId): Model|Builder
    {
        $user = User::find($userId);
        $user->update($userData);
        self::syncPermissions($user, Arr::get($userData, 'permissions', []));
        return $user;
    }

    public static function syncPermissions($user, $permissions)
    {
        $user->syncPermissions($permissions);
    }

    public static function delete(User $user): ?bool
    {
        return $user->delete();
    }

    public static function updatePassword(string $password, int $id): Model|Collection|static
    {
        $user              = User::findOrFail($id);
        $user->password    = bcrypt($password);
        $user->save();

        return $user;
    }
}
