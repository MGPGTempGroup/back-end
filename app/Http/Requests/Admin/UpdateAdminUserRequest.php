<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $adminUser = auth('api')->user();

        return [
            'email' => [
                'email',
                Rule::unique('admin_users', 'email')->ignore($adminUser->id)
            ],
            'name' => 'string'
        ];
    }
}
