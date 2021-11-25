<?php

namespace App\Modules\Auth\Domain\Service;

use App\Modules\Auth\AuthDto;
use App\Modules\Auth\Domain\AuthFilter;
use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

/**
 * AuthLogin service
 */
class AuthLogin extends BaseService
{
    private $filter;

    public function __construct(AuthFilter $filter)
    {
        $this->filter = $filter;
    }

    public function __invoke(array $data): Payload
    {
        $authDto = $this->makeDto($data, new AuthDto);

        if (!$this->filter->forLogin($authDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        $token = Auth::attempt($data);
        if (!$token) {
            $messages = "Your login information you entered did not matched our records. Please double check and try again";
            return $this->newPayload(Payload::STATUS_AUTH_LOGGED_OUT, compact('messages'));
        }

        $ttl = Auth::factory()->getTTL();
        $newToken = auth()->factory()->setTTL($ttl * 24 * 7)->make()->toArray();
        $refreshToken = JWTAuth::getJWTProvider()->encode($newToken);

        return $this->newPayload(Payload::STATUS_AUTH_LOGGED_IN, [
            'at' => $token,
            'at_expires' => $ttl,
            'rt' => $refreshToken,
            'rt_expires' => Auth::factory()->getTTL()
        ]);
    }
}
