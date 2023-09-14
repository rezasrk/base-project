<?php

namespace App\Http\Resources\Supply;

use App\Http\Resources\BaseinfoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'title' => $this->category_title,
            'code' => $this->code,
            'discipline' => new BaseinfoResource($this->discipline),
            'unit' => new BaseinfoResource($this->unit)
        ];
    }
}
