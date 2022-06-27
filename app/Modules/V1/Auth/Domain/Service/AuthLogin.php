<?php

namespace App\Modules\V1\Auth\Domain\Service;

use App\Exceptions\BannedUserException;
use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Auth\AuthDto;
use App\Modules\V1\Auth\Domain\AuthFilter;
use App\Modules\V1\Auth\Domain\Service\Utilities\AuthProxy;
use App\Modules\V1\User\Repository\UserRepository;

class AuthLogin extends BaseService
{
    public function __construct(
        private AuthProxy $proxy,
        private AuthFilter $filter,
        private UserRepository $repo
    ) {
    }

    public function __invoke(array $data): Payload
    {
        if (!$this->filter->forLogin($data)) {
            return $this->newPayload(Payload::STATUS_NOT_VALID, [
                'data' => [],
                'messages' => $this->filter->getValidationMessage(),
            ]);
        }
        $authDto = new AuthDto($this->filter->getValidatedData());
        try {
            $this->repo->findForUser($authDto->username);
            $token = $this->proxy->grantPasswordToken($authDto->getData());
        } catch (\Exception $e) {
            $messages = ($e instanceof BannedUserException) ? $e->getMessage() : null;
            return $this->newPayload(Payload::STATUS_AUTH_NOT_VALID, compact('messages'));
        }

        return $this->newPayload(Payload::STATUS_AUTH_LOGGED_IN, compact('token'));
    }
}
