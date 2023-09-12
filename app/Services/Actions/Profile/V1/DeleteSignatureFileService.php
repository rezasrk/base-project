<?php

namespace App\Services\Actions\Profile\V1;

use App\Models\User;

class DeleteSignatureFileService
{
    public function handle(int $userId)
    {
        User::query()->findOrFail($userId)->update(['signature_path' => null]);
    }
}
