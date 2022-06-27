<?php

namespace App\Modules\V1\User\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Auth\Domain\Jobs\DeleteToken;
use App\Modules\V1\User\Domain\UserFilter;
use App\Modules\V1\User\Repository\UserRepository;
use App\Modules\V1\User\UserDto;
use Illuminate\Support\Str;

class UserSoftDelete extends BaseService
{
    public function __construct(
        private UserFetch $fetch,
        private UserFilter $filter,
        private UserRepository $repo
    ) {
    }

    public function __invoke(int $id, array $data): Payload
    {
        if (($user = $this->fetch->__invoke($id))->getStatus() != 'FOUND') {
            return $user;
        };
        if (
            (!auth()->user()->getRoleNames()->containsStrict(config('app-config.super_admin_role_name')) &&
                $user->getResult()['data']->getRoleNames()->contains(function ($value) {
                    return Str::contains($value, config('app-config.super_admin_role_name'));
                }) ||
                (auth()->user()->id == $id))
        ) {
            return $this->newPayload(Payload::STATUS_FORBIDDEN);
        };

        if (!$this->filter->forSoftDelete($data)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }
        $userDto = new UserDto($this->filter->getValidatedData());

        DeleteToken::dispatchSync($user->getResult()['data']->email);
        $this->repo->update([
            'deleted_reason' => $userDto->deleted_reason
        ], $id)->delete();

        return $this->newPayload(Payload::STATUS_DELETED, [
            'messages' => 'User soft deleted'
        ]);
    }
}
