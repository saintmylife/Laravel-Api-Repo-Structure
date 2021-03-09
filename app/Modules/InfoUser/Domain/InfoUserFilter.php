<?php

namespace App\Modules\InfoUser\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rule;

/**
 * InfoUser filter
 */
class InfoUserFilter extends BaseFilter
{
    public function forUpdate(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        $this->rules['password'] = 'nullable|min:5';
        $this->rules['username'] = [
            'required',
            Rule::unique('info_users')->ignore($data->id),
        ];
        return $this->basic($data);
    }

    protected function setBasicRule()
    {
        $this->rules = [
            'name'      => 'required|min:5',
            'email'  => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
        ];
    }
}
