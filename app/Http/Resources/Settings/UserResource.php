<?php

namespace App\Http\Resources\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'family' => $this->family,
            'username' => $this->username,
            'projects' => new ProjectResourceCollection($this->projects),
            'roles' => new RoleResourceCollection($this->roles),
        ];
    }
}
