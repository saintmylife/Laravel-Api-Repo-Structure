<?php

namespace App\Modules\V1\User\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\User\Domain\UserFilter;
use App\Modules\V1\User\Repository\UserRepository;
use App\Modules\V1\User\Resources\UserResource;
use App\Modules\V1\User\UserDto;

class UserChangeRole extends BaseService
{
    public function __construct(private UserFetch $fetch, private UserFilter $filter, private UserRepository $repo)
    {
    }

    public function __invoke(int $id, array $data): Payload
    {
        if (($user = $this->fetch->__invoke($id))->getStatus() != 'FOUND') {
            return $user;
        };

        if ($user->getResult()['data']->getRoleNames()->containsStrict(config('app-config.super_admin_role_name'))) {
            return $this->newPayload(Payload::STATUS_FORBIDDEN);
        };

        if (!$this->filter->forChangeRole($data)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }

        $userDto = new UserDto($this->filter->getValidatedData());
        $update = new UserResource($user->getResult()['data']->syncRoles($userDto->role));

        return $this->newPayload(Payload::STATUS_UPDATED, compact('update'));
    }
}
