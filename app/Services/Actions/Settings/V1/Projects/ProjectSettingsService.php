<?php

namespace App\Services\Actions\Settings\V1\Projects;

use App\Models\Project;
use App\Services\Actions\Settings\V1\Projects\DTO\ProjectSettingsRequestDTO;
use Illuminate\Validation\ValidationException;

class ProjectSettingsService
{
    public function handle(ProjectSettingsRequestDTO $projectSettingsRequestDTO)
    {
        $project = Project::query()->findOrFail($projectSettingsRequestDTO->getProjectId());

        $this->updateProjectSettings($project, $projectSettingsRequestDTO);
    }

    private function checkPreRequestCode(): void
    {
        // if project has request this method should throw new ProjectException 
    }

    private function updateProjectSettings(Project $project, ProjectSettingsRequestDTO $projectSettingsRequestDTO): void
    {
        $project->update([
            'settings' => [
                'supply' => [
                    'pre_request_code' => $projectSettingsRequestDTO->getPreRequestCode(),
                    'status' => [
                        'first_status' => $projectSettingsRequestDTO->getFirstRequestStatusId(),
                        'last_status' => $projectSettingsRequestDTO->getLastRequestStatusId(),
                        'between_statuses' => $projectSettingsRequestDTO->getBetweenStatusIds(),
                    ],
                ],
            ],
        ]);
    }
}
