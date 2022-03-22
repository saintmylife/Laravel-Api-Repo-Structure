<?php

namespace App\Modules\Auth\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rules\Password;

class AuthFilter extends BaseFilter
{
    const TABLE_NAME = 'users';

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
