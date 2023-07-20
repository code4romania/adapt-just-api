<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class SystemController extends Controller
{
    public function ping(): JsonResponse
    {
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
