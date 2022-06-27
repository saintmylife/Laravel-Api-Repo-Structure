<?php

namespace App\Modules\V1\Auth\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Auth\AuthDto;
use App\Modules\V1\Auth\Domain\AuthFilter;
use App\Modules\V1\User\Domain\UserFilter;
use App\Modules\V1\User\Repository\UserRepository;
use App\Modules\V1\User\Resources\UserResource;
use Illuminate\Support\Facades\Storage;
use Faker\Generator;

class AuthRegister extends BaseService
{
    public function __construct(
        private AuthFilter $filter,
        private UserFilter $userFilter,
        private UserRepository $repo,
        private Generator $generator
    ) {
    }

    public function __invoke(array $data): Payload
    {
        if (!$this->filter->forRegister($data)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }
        $authDto = new AuthDto($this->filter->getValidatedData());
        $authDto->encryptPassword()->generateOtp();

        $create = new UserResource($this->repo->create($authDto->getData()));
        $create->syncRoles($authDto->role);
        $create->sendEmailVerificationNotification();

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
