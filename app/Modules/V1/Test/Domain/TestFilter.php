<?php

namespace App\Modules\V1\Test\Domain;

use App\Modules\Base\Domain\BaseFilter;

class TestFilter extends BaseFilter
{
    const TABLE_NAME = 'tests';

    public function forUpdate(array $data, int $id = null): bool
    {
        $this->setMessages([]);
        $this->setRules($this->basicRule());
        return $this->validate($data);
    }

    public function basicRule(): array
    {
        return [
            'name'  => ['required'],
        ];
    }
    public function prepareData(array $data): array
    {
        return [];
    }
}
