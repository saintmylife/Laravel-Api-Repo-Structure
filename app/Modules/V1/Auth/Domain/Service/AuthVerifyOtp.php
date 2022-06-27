<?php

namespace App\Modules\V1\Auth\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Auth\AuthDto;
use App\Modules\V1\Auth\Domain\AuthFilter;
use App\Modules\V1\User\Repository\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthVerifyOtp extends BaseService
{
    public function __construct(private AuthFilter $filter, private UserRepository $repo)
    {
    }

    public function __invoke(array $data): Payload
    {
        if (!$this->filter->forVerifyOtp($data)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }
        $authDto = new AuthDto($this->filter->getValidatedData());
        try {
            $user = $this->repo->findEmailOrUsername($authDto->username);
            if ($user->hasVerifiedEmail()) {
                return $this->newPayload(Payload::STATUS_AUTH_VERIFY_OTP_ALREADY);
            }
            if (now() > $user->otp_expired_at) {
                return $this->newPayload(Payload::STATUS_AUTH_VERIFY_OTP_EXPIRED);
            }
            $user->markEmailAsVerified();
        } catch (ModelNotFoundException) {
            return $this->newPayload(Payload::STATUS_AUTH_NOT_VALID);
        }

        return $this->newPayload(Payload::STATUS_AUTH_VERIFY_OTP_SUCCESS);
    }
}
