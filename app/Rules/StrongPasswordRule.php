<?php

namespace App\Rules;

use App\Services\General\Support\StrongPasswordService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPasswordRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! StrongPasswordService::check($value)) {
            $fail(__('validation.strong_password'));
        }
    }
}
