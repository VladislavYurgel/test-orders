<?php

namespace App\Services\ResponseApi;

use App\Helpers\ApiHelper;
use App\Services\ResponseApi\Contracts\ResponseApiInterface;
use Illuminate\Http\JsonResponse;

class ResponseApi implements ResponseApiInterface
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
    public function send(array $result = [], array $messages = [], $status = null, $token = null): JsonResponse
    {
        if (is_null($status)) {
            $status = empty($messages) ? ApiHelper::STATUS_SUCCESS : ApiHelper::STATUS_ERROR;
        }

        return response()->json(compact('status', 'result', 'messages', 'token'));
    }

    /**
     * Send success result with specified data
     *
     * @param array $result
     * @param string|null $token
     * @return JsonResponse
     */
    public function success(array $result = [], $token = null): JsonResponse
    {
        return $this->send($result, [], ApiHelper::STATUS_SUCCESS, $token);
    }

    /**
     * Send error result with specified error messages
     *
     * @param array $messages
     * @param string|null $token
     * @return JsonResponse
     */
    public function error(array $messages = [], $token = null): JsonResponse
    {
        return $this->send([], $messages, ApiHelper::STATUS_ERROR, $token);
    }
}
