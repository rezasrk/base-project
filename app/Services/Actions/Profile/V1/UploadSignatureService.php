<?php

namespace App\Services\Actions\Profile\V1;

use App\Models\User;
use Illuminate\Http\UploadedFile;

class UploadSignatureService
{
    public function handel(int $userId, UploadedFile $uploadedFile): string
    {
        $path = $uploadedFile->store('signature');

        User::query()->findOrFail($userId)->update([
            'signature_path' => $path,
        ]);

        return $path;
    }
}
