<?php

namespace App\Http\Requests\Settings\V1\Projects;

use App\Http\Requests\BaseFormRequest;

class StoreProjectRequest extends BaseFormRequest
{
    public function rules()
    {

        return [
            'title' => ['required', 'unique:projects,project_title', 'max:190'],
        ];
    }

    public function bodyParameters()
    {
        return [
            'title' => [
                'description' => 'Title of project',
                'example' => 'Bahrebardari ',
            ],
        ];
    }
}
