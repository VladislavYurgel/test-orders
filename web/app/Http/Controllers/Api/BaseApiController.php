<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\ResponseApi\Contracts\ResponseApiInterface;
use Tymon\JWTAuth\Contracts\JWTSubject;

class BaseApiController
{
    /**
     * @var ResponseApiInterface
     */
    protected $response;

    /**
     * BaseApiController constructor.
     * @param ResponseApiInterface $responseApi
     */
    public function __construct(ResponseApiInterface $responseApi)
    {
        $this->response = $responseApi;
    }

    /**
     * @return User|JWTSubject
     */
    public function user(): User
    {
        return \JWTAuth::parseToken()->toUser();
    }
}
