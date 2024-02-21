<?php

namespace App\Http\Controllers;

use App\Http\Requests\Complaint\GetInstitutionsRequest;
use App\Http\Requests\Complaint\StoreComplaintRequest;
use App\Http\Requests\Complaint\UpdateComplaintRequest;
use App\Http\Resources\Complaint\ComplaintResource;
use App\Models\Complaint;
use App\Models\Location;
use App\Services\ComplaintService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ComplaintController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Complaint::class);
        $perPage = $request->get('page_size', 10);
        $complaints = ComplaintService::complaints($perPage);

        return ComplaintResource::collection($complaints);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreComplaintRequest $request): JsonResponse
    {
        $complaint = ComplaintService::create($request->validated());
        ComplaintService::sendEmail($complaint);

        return $this->sendSuccess('Sesizarea a fost inregistrata cu succes.');
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


    public function institutions(GetInstitutionsRequest $request)
    {
        $victim = $request->get('victim', null);
        $type   = $request->get('type', null);
        $locationId = $request->get('location_id', null);
        $lat = $request->get('lat', null);
        $lng = $request->get('lng', null);
        $countyISO = null;

        if ($locationId) {
            $location = Location::findOrFail($locationId);
            $countyISO = $location->county_id;
        }

        $institutionDetails = ComplaintService::getInsititutionsDetails($victim, $type, $countyISO, $lat, $lng);

        return [
            'emails' => $institutionDetails['emails'] ?? [],
            'institutions' => $institutionDetails['types'] ?? [],
        ];
    }
}
