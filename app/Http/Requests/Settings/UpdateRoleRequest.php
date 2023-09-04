<?php

namespace App\Http\Requests\Settings;

use App\Http\Requests\BaseFormRequest;

class UpdateRoleRequest extends BaseFormRequest
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

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'This name should be unique in this panel',
                'example' => 'Writer',
            ],
            'permissions' => [
                'description' => 'Permission',
                'example' => [1],
            ],
            'status' => [
                'description' => 'Status of role',
                'status' => '{1=active},{0=inactive}',
            ],
        ];
    }
}
