<?php

namespace App\Modules\V1\User\Domain;

use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Password;

class UserFilter extends BaseFilter
{
    const TABLE_NAME = 'users';

    public function forInsert(array $data): bool
    {
        $this->setRules(Arr::except($this->basicRule(), ['password', 'avatar']));
        $this->basicRuleForRole();
        return $this->validate($data);
    }
    public function forUpdate(array $data, int $id = null): bool
    {
        $this->setRules(
            Arr::only(
                $this->basicRule(),
                ['name', 'phone', 'address', 'phone']
            )
        );
        if (!empty($data['avatar']) && is_file($data['avatar'])) {
            $this->setRulesByKey('avatar', $this->basicRule()['avatar']);
        }
        return $this->validate($data);
    }
    public function forChangeRole(array $data): bool
    {
        $this->basicRuleForRole();
        return $this->validate($data);
    }
    public function forSoftDelete(array $data): bool
    {
        $this->setRules([
            'deleted_reason' => ['required', 'string']
        ]);
        return $this->validate($data);
    }

    public function basicRuleForRole()
    {
        $this->setRulesByKey(
            'role',
            ['required', 'exists:roles,name', 'not_in:' . (config('app-config.super_admin_role_name'))]
        );
    }

    public function basicRule(): array
    {
        return [
            'email' => ['required', 'email', 'unique:' . self::TABLE_NAME],
            'username' => ['required', 'alpha_num', 'unique:' . self::TABLE_NAME, 'min:6'],
            'password' => ['required', Password::defaults()],
            'name' => ['required', 'string', 'min:4'],
            'address' => ['nullable', 'string', 'min:4'],
            'phone' =>  [
                'required', 'numeric', 'min:6',
                function ($attribute, $value, $fail) {
                    if ($value[0] == 0) {
                        $fail('Invalid format, ' . $attribute . ' cant start with 0');
                    }
                }
            ],
            'language' => ['nullable', 'in:id,eng'],
        ];
    }
    public function prepareData(array $data): array
    {
        return [];
    }
}
