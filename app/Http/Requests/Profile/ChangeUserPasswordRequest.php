<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseFormRequest;
use App\Rules\StrongPasswordRule;

class ChangeUserPasswordRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'old_password' => ['required', 'min:8', 'max:190'],
            'new_password' => ['required', 'min:8', 'max:190', new StrongPasswordRule]
        ];
    }

    public function bodyParameters()
    {
        return [
            'old_password' => [
                'description' => "The old user's password ",
                'example' => 'DKRusk1342123',
            ],
            'new_password' => [
                'description' => "The new user's password ",
                'example' => 'Okdighr542',
            ]
        ];
    }
}
