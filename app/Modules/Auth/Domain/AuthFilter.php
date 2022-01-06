<?php

namespace App\Modules\Auth\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;

/**
 * Auth filter
 */
class AuthFilter extends BaseFilter
{
    public function forLogin(BaseDto $data): bool
    {
        return $this->forInsert($data);
    }

    protected function setBasicRule()
    {
        $this->rules = [
            'email' => 'email|required',
            'password' => 'required|min:5',
        ];
    }
}
