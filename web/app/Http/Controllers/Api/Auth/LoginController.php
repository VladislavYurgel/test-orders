<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\ApiException;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class LoginController extends BaseApiController
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->attempt($request);

        $this->validateToken($token);

        /** @var User $user */
        $user = \JWTAuth::setToken($token)->toUser();

        return $this->response->success([trans('auth.welcome_message', ['email' => $user->email])], $token);
    }

    /**
     * @param LoginRequest $request
     * @return false|string
     */
    private function attempt(LoginRequest $request)
    {
        return \JWTAuth::attempt($request->only('email', 'password'));
    }

    /**
     * @param $token
     * @throws \Throwable
     */
    private function validateToken($token)
    {
        // If received token is empty then send authenticated error message
        throw_unless($token, new ApiException(trans('auth.failed')));
    }
}
