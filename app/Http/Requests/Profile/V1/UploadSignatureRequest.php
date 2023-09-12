<?php

namespace App\Http\Requests\Profile\V1;

use App\Http\Requests\BaseFormRequest;

class UploadSignatureRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'signature_file' => ['required'],
        ];
    }

    public function bodyParameters()
    {
        return [
            'signature_file' => [
                'description' => 'Signature of the user',
                'example' => '/var/www/sing.jpeg',
            ],
        ];
    }
}
