<?php

namespace App\Http\Requests\Profile\V1;

use App\Http\Requests\BaseFormRequest;

class UpdateUserProfileRequest extends BaseFormRequest
{
    public function rules()
    {
        if ($this->isDocsEnvironment()) {
            $userId = 1;
        } else {
            $userId = $this->user()->id;
        }

        return [
            'username' => ['required', 'max:100', 'unique:users,username,'.$userId.',id'],
            'email' => ['required', 'max:190', 'unique:users,email,'.$userId.',id'],
            'name' => ['required', 'max:100'],
            'family' => ['required', 'max:100'],
        ];
    }

    public function bodyParameters()
    {
        return [
            'username' => [
                'description' => 'This username should be unique in this panel',
                'example' => 'username',
            ],
            'email' => [
                'description' => 'This email should be unique in this panel',
                'example' => 'example@gmail.com',
            ],
            'name' => [
                'description' => 'Name of user',
                'example' => 'Ali',
            ],
            'family' => [
                'description' => 'Family of user',
                'example' => 'Mohammad',
            ],
        ];
    }
}
