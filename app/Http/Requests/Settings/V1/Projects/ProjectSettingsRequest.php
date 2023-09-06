<?php

namespace App\Http\Requests\Settings\V1\Projects;

use App\Enum\BaseinfoTypesEnum;
use App\Http\Requests\BaseFormRequest;

class ProjectSettingsRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'settings' => ['present', 'array'],
            'settings.supply' => ['present', 'array'],
            'settings.supply.pre_request_code' => ['required', 'string', 'min:3', 'max:3'],
            'settings.supply.status' => ['present', 'array'],
            'settings.supply.status.first_status' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::REQUEST_STATUS->value],
            'settings.supply.status.between_statuses' => ['present', 'array', 'min:2'],
            'settings.supply.status.between_statuses.*' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::REQUEST_STATUS->value],
            'settings.supply.status.last_status' => ['required', 'exists:baseinfos,id,type,' . BaseinfoTypesEnum::REQUEST_STATUS->value],
        ];
    }

    public function bodyParameters()
    {
        return [
            'settings.supply.pre_request_code' => [
                'description' => 'Pre request code of the project',
                'example' => '547'
            ],
            'settings.supply.status.first_status' => [
                'description' => "First status of the project's request",
                'example' => 12,
            ],
            'settings.supply.status.between_statuses.*' => [
                'description' => "Statuses between first status and last status ",
                'example' => 45,
            ],
            'settings.supply.status.last_status' => [
                'description' => "Last status of the project's request",
                'example' => 75,
            ]
        ];
    }
}
