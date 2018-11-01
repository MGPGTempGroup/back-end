<?php

namespace App\Http\Requests\Admin;

use Dingo\Api\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Illuminate\Contracts\Validation\Validator;

class BaseRequest extends FormRequest
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
     * Custom form request exception information
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new BadRequestHttpException($validator->errors()->first());
    }
}
