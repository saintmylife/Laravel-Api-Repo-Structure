<?php

namespace App\Modules\V1\Auth\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\Auth\AuthDto;
use App\Modules\V1\Auth\Domain\AuthFilter;
use App\Modules\V1\Auth\Domain\Jobs\DeleteToken;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthResetPassword extends BaseService
{
    public function __construct(private AuthFilter $filter)
    {
    }

    public function __invoke(array $data): Payload
    {
        if (!$this->filter->forResetPassword($data)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }
        $authDto = new AuthDto($this->filter->getValidatedData());
        $dbForReset = [
            'email' => $authDto->email,
            'password' => $authDto->password,
            'password_confirmation' => $authDto->password_confirmation,
            'token' => $authDto->token,
        ];
        $password = Password::reset($dbForReset, function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password)
            ]);
            $user->save();
            event(new PasswordReset($user));
        });
        if ($password == Password::RESET_THROTTLED) {
            return $this->newPayload(Payload::STATUS_THROTTLED);
        }
        if ($password !== 'passwords.reset') {
            return $this->newPayload(Payload::STATUS_AUTH_RESET_PASSWORD_FAILED);
        }
        DeleteToken::dispatchAfterResponse($authDto->email);

        return $this->newPayload(Payload::STATUS_AUTH_RESET_PASSWORD_SUCCESS);
    }
}
