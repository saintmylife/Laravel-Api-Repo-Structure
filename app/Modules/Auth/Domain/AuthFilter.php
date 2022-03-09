<?php

namespace App\Modules\Auth\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rules\Password;

/**
 * Auth filter
 */
class AuthFilter extends BaseFilter
{
    public function forLogin(BaseDto $data): bool
    {
        $this->messages = [];
        $this->rules = [
            'email' => ['required', 'string'],
            'password' => ['required', 'string']
        ];
        return $this->basic($data);
    }

    protected function setBasicRule()
    {
        $this->rules = [
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
