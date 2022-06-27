<?php

namespace App\Modules\V1\User\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Auth\Domain\Jobs\DeleteToken;
use App\Modules\V1\User\Repository\UserRepository;

class UserDelete extends BaseService
{
    public function __construct(private UserRepository $repo)
    {
    }

    public function __invoke(): Payload
    {
        if (($user = auth()->user())->getRoleNames()->containsStrict(config('app-config.super_admin_role_name'))) {
            return $this->newPayload(Payload::STATUS_FORBIDDEN);
        }
        $this->repo->forceDelete($user->id);
        DeleteToken::dispatchSync($user->email);
        $messages = 'User Deleted';
        return $this->newPayload(Payload::STATUS_DELETED, compact('messages'));
    }
}
