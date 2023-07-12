<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Services\ComplaintService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class SystemController extends Controller
{
    public function ping(): JsonResponse
    {

        $complaint = Complaint::find(2);
        ComplaintService::sendEmail($complaint);

        return response()->json(['message' => 'Pong']);
    }

    public function healthCheck(): JsonResponse
    {
        try {
            DB::connection()->getPdo();
        } catch (Throwable $e) {
            return response()->json(['message' => 'Not healthy'], 503);
        }

        return response()->json(['message' => 'Healthy']);
    }
}
