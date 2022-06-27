<?php

namespace App\Modules\V1\Auth\Domain\Service;

use App\Exceptions\BannedUserException;
use App\Modules\V1\Auth\AuthDto;
use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Auth\Domain\AuthFilter;
use App\Modules\V1\User\Repository\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthLoginCheck extends BaseService
{
    public function __construct(private AuthFilter $filter, private UserRepository $repo)
    {
    }

    public function __invoke(array $data): Payload
    {
        if (!$this->filter->forLoginCheck($data)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }
        $authDto = new AuthDto($this->filter->getValidatedData());
        try {
            $this->repo->findForUser($authDto->username);
        } catch (ModelNotFoundException | BannedUserException $e) {
            $messages = ($e instanceof BannedUserException) ? $e->getMessage() : null;
            return $this->newPayload(Payload::STATUS_AUTH_NOT_VALID, compact('messages'));
        }

        return $this->newPayload(Payload::STATUS_AUTH_FOUND);
    }
}
