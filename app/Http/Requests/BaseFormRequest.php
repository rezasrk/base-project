<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class BaseFormRequest extends FormRequest
{
    protected function isDocsEnvironment(): bool
    {
        return App::environment('docs');
    }
}
