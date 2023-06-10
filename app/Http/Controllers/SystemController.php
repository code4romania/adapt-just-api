<?php

namespace App\Http\Controllers;

use App\Services\UploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class SystemController extends Controller
{
    public function ping(): JsonResponse
    {
        UploadService::parseHtmlContent(
            '
            <p><img src="https://adapt-just-staging.s3.eu-west-1.amazonaws.com/temp/jr4qz3kit9WhlTw0e0e2QCwT6zRZzxuibjnLJFPF.png?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&amp;X-Amz-Algorithm=AWS4-HMAC-SHA256&amp;X-Amz-Credential=AKIASQDJNISKZDXKOB66%2F20230609%2Feu-west-1%2Fs3%2Faws4_request&amp;X-Amz-Date=20230609T151523Z&amp;X-Amz-SignedHeaders=host&amp;X-Amz-Expires=172800&amp;X-Amz-Signature=e5e8c380053975e5ea3a6e289e56f90d26814ebe5d6bdc1e56c0bc81e832c92d" alt="" width="140" height="44" /> sdsdasdsadsa</p>
<p>&nbsp;</p>
<p><img src="https://adapt-just-staging.s3.eu-west-1.amazonaws.com/temp/qY8ojSdDlrEj5HmTnAkDYhkKj2XYHsEj4JHOIB5I.png?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&amp;X-Amz-Algorithm=AWS4-HMAC-SHA256&amp;X-Amz-Credential=AKIASQDJNISKZDXKOB66%2F20230609%2Feu-west-1%2Fs3%2Faws4_request&amp;X-Amz-Date=20230609T151856Z&amp;X-Amz-SignedHeaders=host&amp;X-Amz-Expires=172800&amp;X-Amz-Signature=a29bc90b4dc86ada9987b49525f18bbdbc8aae9af1267f0739015904a044d62d" alt="" width="150" height="129" /> dsdsds</p>
<p>dsfds</p>'
        );

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
