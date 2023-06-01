<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\Permission;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', User::class);
        $users = UserService::users();

        return UserResource::collection($users);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);
        UserService::create($request->validated());

        return $this->sendSuccess('The user has been successfully created.');
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', User::class);
        UserService::update($request->validated(), $user->id);

        return $this->sendSuccess('The user has been successfully updated.');
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function show(User $user): UserResource
    {
        $this->authorize('view', User::class);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', [User::class, $user]);
        UserService::delete($user);

        return $this->sendSuccess('The user has been successfully deleted.');
    }

    /**
     * @throws AuthorizationException
     */
    public function form( Request $request): JsonResponse
    {
        $this->authorize('create', User::class);

        return new JsonResponse([
            'permissions'       => Permission::all(),
        ]);
    }
}
