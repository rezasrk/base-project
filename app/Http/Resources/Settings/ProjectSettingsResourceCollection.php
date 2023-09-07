<?php

namespace App\Http\Resources\Settings;

use App\Models\Baseinfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectSettingsResourceCollection extends ResourceCollection
{
    public function toArray(Request $request)
    {
        $settings = $this->collection->all();

        return [
            'supply' => [
                'pre_request_code' => $settings['supply']['pre_request_code'] ?? null,
                'status' => [
                    'first_status' => $this->getFirstStatus($settings),
                    'last_status' => $this->getLastStatus($settings),
                    'between_statuses' => $this->getBetweenStatuses($settings)
                ],
            ]
        ];
    }

    private function getFirstStatus(array $settings)
    {
        $baseinfo = Baseinfo::query()->where('id', $settings['supply']['status']['first_status'] ?? null)->first();

        return [
            'id' => optional($baseinfo)->id,
            'value' => __(optional($baseinfo)->value)
        ];
    }

    private function getLastStatus(array $settings)
    {
        $baseinfo = Baseinfo::query()->where('id', $settings['supply']['status']['last_status'] ?? null)->first();

        return [
            'id' => optional($baseinfo)->id,
            'value' => __(optional($baseinfo)->value)
        ];
    }

    private function getBetweenStatuses(array $settings): array
    {
        return Baseinfo::query()->whereIn('id', $settings['supply']['status']['between_statuses'] ?? [])
            ->get()
            ->map(function ($baseinfo) {
                return [
                    'id' => optional($baseinfo)->id,
                    'value' => __(optional($baseinfo)->value)
                ];
            })->all();
    }
}
