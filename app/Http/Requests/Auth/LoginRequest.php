<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;

class LoginRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'username' => ['required', 'max:190'],
            'password' => ['required', 'max:190'],
        ];
    }
}
