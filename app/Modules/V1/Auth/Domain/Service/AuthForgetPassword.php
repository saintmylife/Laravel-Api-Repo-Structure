<?php

namespace App\Modules\V1\Auth\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Auth\AuthDto;
use App\Modules\V1\Auth\Domain\AuthFilter;
use Illuminate\Support\Facades\Password;;

class AuthForgetPassword extends BaseService
{
    public function __construct(private AuthFilter $filter)
    {
    }

    public function __invoke(array $data): Payload
    {
        if (!$this->filter->forForgetPassword($data)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }
        $authDto = new AuthDto($this->filter->getValidatedData());

        $password = Password::sendResetLink([
            'email' => $authDto->email
        ]);

        if ($password == Password::RESET_THROTTLED) {
            return $this->newPayload(Payload::STATUS_THROTTLED);
        }
        if ($password !== Password::RESET_LINK_SENT) {
            return $this->newPayload(Payload::STATUS_AUTH_NOT_VALID);
        }

        return $this->newPayload(Payload::STATUS_AUTH_SEND_EMAIL);
    }
}
