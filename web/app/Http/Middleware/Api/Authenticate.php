<?php

namespace App\Http\Middleware\Api;

use App\Exceptions\ApiException;
use App\Services\ResponseApi\Contracts\ResponseApiInterface;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\JWTAuth;

class Authenticate
{
    /**
     * @var ResponseApiInterface
     */
    private $responseApi;

    /**
     * @var JWTAuth
     */
    private $auth;

    /**
     * Authenticate constructor.
     * @param ResponseApiInterface $responseApi
     * @param JWTAuth $JWTAuth
     */
    public function __construct(ResponseApiInterface $responseApi, JWTAuth $JWTAuth)
    {
        $this->responseApi = $responseApi;
        $this->auth = $JWTAuth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws \Throwable
     */
    public function handle($request, \Closure $next)
    {
        $token = $this->auth->setRequest($request)->getToken();

        throw_unless($token, new ApiException(trans('auth.jwt.token_not_provided')));

        try {
            $user = $this->auth->setToken($token)->authenticate();
        } catch (TokenExpiredException $exception) {
            $newToken = $this->auth->setRequest($request)->parseToken()->refresh();

            return $this->responseApi->error([trans('auth.jwt.token_expired')], $newToken);
        } catch (\Throwable $exception) {
            throw new ApiException($exception->getMessage());
        }

        throw_unless($user, new ApiException(trans('auth.failed')));

        return $next($request);
    }
}
