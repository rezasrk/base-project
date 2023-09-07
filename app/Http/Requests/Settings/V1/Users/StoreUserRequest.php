<?php

namespace App\Http\Requests\Settings\V1\Users;

use App\Enum\BaseinfoTypesEnum;
use App\Http\Requests\BaseFormRequest;
use App\Rules\StrongPasswordRule;

class StoreUserRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'username' => ['required', 'unique:users,username'],
            'name' => ['required', 'string', 'max:160'],
            'family' => ['required', 'string', 'max:160'],
            'password' => ['nullable', new StrongPasswordRule],
            'projects' => ['present', 'array', 'min:1'],
            'request_statuses' => ['present', 'array', 'min:1'],
            'request_types' => ['present', 'array', 'min:1'],
            'roles' => ['present', 'array', 'min:1'],
            'projects.*' => ['required', 'int', 'exists:projects,id'],
            'request_statuses.*' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::REQUEST_STATUS->value],
            'request_types.*' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::REQUEST_TYPE->value],
            'roles.*' => ['required', 'exists:roles,id'],
        ];
    }
}
