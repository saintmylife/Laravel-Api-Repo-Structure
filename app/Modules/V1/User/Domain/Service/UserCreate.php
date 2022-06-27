<?php

namespace App\Modules\V1\User\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Auth\AuthDto;
use App\Modules\V1\Auth\Domain\Service\AuthRegister;
use App\Modules\V1\User\Domain\UserFilter;
use App\Modules\V1\User\Repository\UserRepository;
use Illuminate\Foundation\Testing\WithFaker;

class UserCreate extends BaseService
{
    use WithFaker;
    public function __construct(
        private AuthRegister $register,
        private UserFilter $filter,
        private UserRepository $repo
    ) {
    }

    public function __invoke(array $data): Payload
    {
        if (!$this->filter->forInsert($data)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }

        $password = \Str::random(random_int(8, 12));
        $userDto = new AuthDto($this->filter->getValidatedData());
        $userDto->password = $password;
        $userDto->encryptPassword()->generateOtp();

        $user = $this->repo->create($userDto->getData());
        $user->syncRoles($userDto->role);
        $user->markEmailAsVerified();
        $create = [
            'email' => $user->email,
            'username' => $user->username,
            'password' => $password
        ];

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
