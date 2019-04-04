<?php

namespace App\Services\ResponseApi\Contracts;

use Illuminate\Http\JsonResponse;

interface ResponseApiInterface
{
    /**
     * Send result with specified data or messages with specified status
     *
     * @param array $result
     * @param array $messages
     * @param int|null $status
     * @param string|null $token
     * @return JsonResponse
     */
    public function send(array $result = [], array $messages = [], $status = null, $token = null): JsonResponse;

    /**
     * Send success result with specified data
     *
     * @param array $result
     * @param string|null $token
     * @return JsonResponse
     */
    public function success(array $result = [], $token = null): JsonResponse;

    /**
     * Send error result with specified error messages
     *
     * @param array $messages
     * @param string|null $token
     * @return JsonResponse
     */
    public function error(array $messages = [], $token = null): JsonResponse;
}
