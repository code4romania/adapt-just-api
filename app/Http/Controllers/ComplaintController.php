<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Complaint\StoreComplaintRequest;
use App\Http\Requests\Complaint\UpdateComplaintRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\Complaint\ComplaintResource;
use App\Http\Resources\User\UserResource;
use App\Models\Complaint;
use App\Models\Permission;
use App\Models\User;
use App\Services\ComplaintService;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ComplaintController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Complaint::class);
        $complaints = ComplaintService::complaints();

        return ComplaintResource::collection($complaints);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreComplaintRequest $request): JsonResponse
    {
        ComplaintService::create($request->validated());

        return $this->sendSuccess('Sesizare a fost inregistrata cu succes.');
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(UpdateComplaintRequest $request, Complaint $complaint): JsonResponse
    {
        $this->authorize('update', Complaint::class);
        ComplaintService::update($request->validated(), $complaint->id);

        return $this->sendSuccess('Sesizarea a fost actualizata cu succes.');
    }

    /**
     * Display the specified resource.
     *
     * @throws AuthorizationException
     */
    public function show(Complaint $complaint): ComplaintResource
    {
        $this->authorize('view', Complaint::class);

        return new ComplaintResource($complaint);
    }


}
