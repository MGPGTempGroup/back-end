<?php

namespace App\Http\Requests\Admin;

use Illuminate\Database\Eloquent\Relations\Relation;

class CreateRemarkRequest extends BaseRequest
{

    public function rules()
    {
        return [
            'content' => 'bail|required|string',
            'come_from_type' => [
                'bail',
                'required',
                'string',
                function ($attribute, $val, $fail) {
                    $morphMapAlias = array_keys(Relation::$morphMap);
                    if (! in_array($val, $morphMapAlias)) {
                        return $fail($attribute . 'is invalid.');
                    }
                    return true;
                }
            ],
            'come_from_id' => [
                'bail',
                'required',
                'numeric',
                function ($attribute, $val, $fail) {
                    $comeFromModel = new Relation::$morphMap[$this->input('come_from_type')];
                    if (! $comeFromModel::where('id', $val)->exists()) {
                        return $fail($attribute . 'is not found');
                    }
                    return true;
                }
            ]
        ];
    }
}
