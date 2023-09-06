<?php

namespace App\Services\Actions\Settings\V1\Projects;

use App\Models\Project;
use App\Services\Actions\Settings\V1\Projects\DTO\ProjectSettingsRequestDTO;

class ProjectSettingsService
{
    public function handle(ProjectSettingsRequestDTO $projectSettingsRequestDTO)
    {
        $project = Project::query()->findOrFail($projectSettingsRequestDTO->getProjectId());

        $project->update([
            'settings' => [
                'supply' => [
                    'pre_request_code' => $projectSettingsRequestDTO->getPreRequestCode(),
                    'status' => [
                        'first_status' => $projectSettingsRequestDTO->getFirstRequestStatusId(),
                        'last_status' => $projectSettingsRequestDTO->getLastRequestStatusId(),
                        'between_statuses' => $projectSettingsRequestDTO->getBetweenStatusIds(),
                    ]
                ]
            ]
        ]);
    }
}
