<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;

class SelectProjectRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'project_id' => ['required', 'exists:projects,id']
        ];
    }

    public function bodyParameters()
    {
        return [
            'project_id' => [
                'description' => 'Id of a project',
                'example' => 2
            ]
        ];
    }
}
