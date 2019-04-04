<?php

namespace App\Http\Requests\Api;

use App\Services\ResponseApi\Contracts\ResponseApiInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        /** @var ResponseApiInterface $responseApi */
        $responseApi = app(ResponseApiInterface::class);

        throw new HttpResponseException($responseApi->error($validator->errors()->messages()));
    }
}
