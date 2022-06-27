<?php

namespace App\Modules\V1\Auth\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Auth\AuthDto;
use App\Modules\V1\Auth\Domain\AuthFilter;
use App\Modules\V1\User\Repository\UserRepository;
use Illuminate\Support\Arr;

class AuthChangePassword extends BaseService
{
    public function __construct(private AuthFilter $filter, private UserRepository $repo)
    {
    }

    public function __invoke(array $data): Payload
    {
        if (!$this->filter->forChangePassword($data)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }
        $authDto = new AuthDto($this->filter->getValidatedData());
        $authDto->encryptPassword();

        $update = $this->repo->update(Arr::only($authDto->getData(), 'password'), auth()->user()->id);

        return $this->newPayload(Payload::STATUS_AUTH_CHANGE_PASSWORD_SUCCESS, compact('update'));
    }
}
