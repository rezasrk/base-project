<?php

namespace App\Services\Actions\Settings\V1\Projects\DTO;

class ProjectSettingsRequestDTO
{
    private array $supplySettings;

    public function __construct(
        private int $projectId,
        private array $settings
    ) {
        $this->supplySettings = $settings['supply'];
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function getPreRequestCode(): ?int
    {
        return $this->supplySettings['pre_request_code'] ?? null;
    }

    public function getFirstRequestStatusId(): ?int
    {
        return $this->supplySettings['status']['first_status'] ?? null;
    }

    public function getLastRequestStatusId(): ?int
    {
        return $this->supplySettings['status']['last_status'] ?? null;
    }

    public function getBetweenStatusIds(): array
    {
        return $this->supplySettings['status']['between_statuses'] ?? null;
    }
}
