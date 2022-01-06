<?php

namespace App\Modules\Auth\Domain\Service;

use App\Modules\Auth\AuthDto;
use App\Modules\Auth\Domain\AuthFilter;
use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Common\Domain\AuthPayload;
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
            return $this->newPayload(AuthPayload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        $token = Auth::attempt($data);
        if (!$token) {
            return $this->newPayload(AuthPayload::STATUS_AUTH_FAILED);
        }

        $newToken = JWTAuth::factory()->setTTL(config('jwt.ttl') * 24 * 7)->make()->toArray();

        return $this->newPayload(AuthPayload::STATUS_AUTHENTICATED, [
            'at' => $token,
            'at_expires' => config('jwt.ttl'),
            'rt' => JWTAuth::getJWTProvider()->encode($newToken),
            'rt_expires' => JWTAuth::factory()->getTTL()
        ]);
    }
}
