<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\Requests\User\PasswordSetupRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;

class PasswordSetupController extends Controller
{

    public function __construct()
    {
        $this->middleware('throttle:60,1')->only('setup', 'verify');
    }

    /**
     * @throws ValidationException
     */
    public function setup(PasswordSetupRequest $request): JsonResponse
    {

        if (!$request->hasValidSignature(false)) {
            return response()->json([
                'success'   => false,
                'message'   => ResponseStatus::$statusTexts[ResponseStatus::HTTP_FORBIDDEN]
            ], ResponseStatus::HTTP_FORBIDDEN);
        }

        $user = User::query()->findOrFail($request->route('id'));
        if (!hash_equals((string)$request->route('id'), (string)$user->getKey())) {
            throw ValidationException::withMessages([
                'email' => ['Invalid URL.'],
            ]);
        }

        if (!hash_equals((string)$request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw ValidationException::withMessages([
                'email' => ['Invalid signature.'],
            ]);
        }

        if ($user->password) {
            throw ValidationException::withMessages([
                'email' => ['Your account already has password.'],
            ]);
        }

        UserService::updatePassword($request->input('password'), $user->id);

        return response()->json([
            'message'   => 'Your password has been saved.',
        ], ResponseStatus::HTTP_OK);
    }
}
