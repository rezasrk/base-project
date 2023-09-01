<?php

namespace App\Http\Requests\Settings;

use App\Http\Requests\BaseFormRequest;

class StoreRoleRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'unique:roles,name'],
            'permissions' => ['present', 'array'],
            'status' => ['required', 'in:1,0'],
            'permissions.*' => ['required'],
        ];
    }
}
