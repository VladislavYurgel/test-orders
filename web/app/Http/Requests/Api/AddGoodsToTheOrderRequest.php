<?php

namespace App\Http\Requests\Api;

/**
 * Class AddGoodToTheOrderRequest
 * @package App\Http\Requests
 * @property-read array $goods
 */
class AddGoodsToTheOrderRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'goods' => 'required|array',
            'goods.*.id' => 'required|integer|exists:goods',
            'goods.*.quantity' => 'required|integer|min:0|max:255',
        ];
    }
}
