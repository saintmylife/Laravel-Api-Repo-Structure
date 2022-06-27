<?php

namespace App\Modules\V1\Auth\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Auth\AuthDto;
use App\Modules\V1\Auth\Domain\AuthFilter;
use App\Modules\V1\User\Repository\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthResendOtp extends BaseService
{
    public function __construct(private AuthFilter $filter, private UserRepository $repo)
    {
    }

    public function __invoke(array $data): Payload
    {
        if (!$this->filter->forLoginCheck($data)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }
        $authDto = new AuthDto($this->filter->getValidatedData());

        try {
            $user = $this->repo->findEmailOrUsername($authDto->username);
            if ($user->hasVerifiedEmail()) {
                return $this->newPayload(Payload::STATUS_AUTH_VERIFY_OTP_ALREADY);
            }
            $authDto->generateOtp();
        } catch (ModelNotFoundException) {
            return $this->newPayload(Payload::STATUS_AUTH_NOT_VALID);
        }

        $this->repo->update([
            'otp' => $authDto->otp,
            'otp_expired_at' => $authDto->otp_expired_at,
        ], $user->id)->sendEmailVerificationNotification();

        return $this->newPayload(Payload::STATUS_AUTH_SEND_EMAIL);
    }
}
