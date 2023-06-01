<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendSuccess($message): JsonResponse
    {
        return response()->json([
            'data' => [
                'success' => true,
                'message' => $message
            ]
        ]);
    }

    public function sendError($error, int $code = 500): JsonResponse
    {
        return response()->json([
            'data' => [
                'success' => false,
                'message' => $error
            ]
        ], $code);
    }
}
