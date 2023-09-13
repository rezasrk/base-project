<?php

namespace App\Services\Actions;

use App\Models\Baseinfo;

class BaseinfoService
{
    public function handle(array $baseTypes): array
    {
        return collect($baseTypes)->mapWithKeys(function ($item) {
            return [
                $item => Baseinfo::query()->where('type', $item)
                    ->where('parent_id', '<>', 0)
                    ->orderBy('type')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'value' => __($item->value)
                        ];
                    })->all()
            ];
        })->all();
    }
}
