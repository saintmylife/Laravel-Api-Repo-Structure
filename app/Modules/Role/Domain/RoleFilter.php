<?php

namespace App\Modules\Role\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rule;

/**
 * Role filter
 */
class RoleFilter extends BaseFilter
{
    public function forUpdate(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        $this->rules['name'] = [
            'required',
            Rule::unique('roles')->ignore($data->id),
        ];
        return $this->basic($data);
    }

    protected function setBasicRule()
    {
        $this->rules = [
            'name'          => 'required|unique:roles,name',
            'permissions'   => 'nullable'
        ];
    }
}
