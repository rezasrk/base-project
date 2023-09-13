<?php

namespace App\Http\Requests\Settings\V1\Users;

use App\Enum\BaseinfoTypesEnum;
use App\Http\Requests\BaseFormRequest;
use App\Rules\StrongPasswordRule;

class UpdateUserRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'username' => ['required', 'unique:users,username,'.$this->route('id').',id'],
            'name' => ['required', 'string', 'max:160'],
            'family' => ['required', 'string', 'max:160'],
            'password' => ['nullable', new StrongPasswordRule],
            'projects' => ['present', 'array', 'min:1'],
            'request_statuses' => ['present', 'array', 'min:1'],
            'request_types' => ['present', 'array', 'min:1'],
            'roles' => ['present', 'array', 'min:1'],
            'projects.*' => ['required', 'int', 'exists:projects,id'],
            'request_statuses.*' => ['required', 'exists:baseinfos,id,type,'.BaseinfoTypesEnum::REQUEST_STATUS->value],
            'request_types.*' => ['required', 'exists:baseinfos,id,type,'.BaseinfoTypesEnum::REQUEST_TYPE->value],
            'roles.*' => ['required', 'exists:roles,id'],
        ];
    }

    public function bodyParameters()
    {
        return [
            'username' => [
                'description' => 'The username of user',
                'example' => 'admin',
            ],
            'name' => [
                'description' => 'The username of user',
                'example' => 'Ali',
            ],
            'family' => [
                'description' => 'The family of user',
                'example' => 'Mohammad',
            ],
            'password' => [
                'description' => 'The password of user',
                'example' => 'ADKSekjdh345',
            ],
            'projects.*' => [
                'description' => 'Assign projects to user',
                'example' => 65,
            ],
            'request_statuses.*' => [
                'description' => 'Assign request statuses to user',
                'example' => 36,
            ],
            'request_types.*' => [
                'description' => 'Assign request types to user',
                'example' => 52,
            ],
            'roles.*' => [
                'description' => 'Assign roles to user',
                'example' => 35,
            ],
        ];
    }
}
