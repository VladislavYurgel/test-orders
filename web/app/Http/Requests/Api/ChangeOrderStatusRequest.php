<?php

namespace App\Http\Requests\Api;

use App\Helpers\Lists\OrderStatusesList;

/**
 * Class ChangeOrderStatusRequest
 * @package App\Http\Requests\Api
 * @property-read int $status
 */
class ChangeOrderStatusRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $availableStatuses = implode(',', array_keys(OrderStatusesList::getList()));

        return [
            'status' => "required|integer|in:{$availableStatuses}",
        ];
    }
}
