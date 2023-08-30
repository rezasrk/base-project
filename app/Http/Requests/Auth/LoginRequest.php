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

    public function bodyParameters()
    {
        return [
            'username' => [
                'description' => 'Username of user.username can be email or username',
                'example' => '{admin} || {admin@gmail.com}',
            ],
            'password' => [
                'description' => 'Password of user.',
                'example' => 'Ekdhgh34521Eugrhc',
            ],
        ];
    }
}
