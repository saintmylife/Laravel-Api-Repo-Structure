<?php

namespace App\Modules\V1\Role\Domain;

use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rule;

class RoleFilter extends BaseFilter
{
    const TABLE_NAME = 'roles';

    public function forUpdate(array $data, int $id = null): bool
    {
        $rules = $this->basicRule();
        $rules['name'][1]->ignore($id);
        $this->setRules($rules);
        return $this->validate($data);
    }

    public function basicRule(): array
    {
        return [
            'name'  => ['required', Rule::unique(self::TABLE_NAME)],
        ];
    }
    public function prepareData(array $data): array
    {
        return [
            'name' => \Str::slug($data['name'])
        ];
    }
}
