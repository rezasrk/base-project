<?php

namespace App\Http\Resources\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'title' => $this->project_title,
            'settings' => $this->settings ? new ProjectSettingsResourceCollection($this->settings) : [],
        ];
    }
}
