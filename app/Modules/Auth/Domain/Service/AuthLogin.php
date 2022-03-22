<?php

namespace App\Modules\Auth\Domain\Service;

use App\Modules\Auth\AuthDto;
use App\Modules\Auth\Domain\AuthFilter;
use App\Modules\Auth\Traits\PassportConfig;
use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\AuthPayload;
use App\Modules\Common\Domain\Payload;
use Illuminate\Support\Facades\Http;

class AuthLogin extends BaseService
{
    use PassportConfig;
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
            return $this->newPayload(AuthPayload::STATUS_AUTH_NOT_VALID, compact('messages', 'data'));
        }

        try {
            $auth = Http::asForm()->post(
                $this->oAuthUrl(),
                $this->oAuthFormData('password', [
                    'username' => $authDto->email,
                    'password' =>  $authDto->password,
                ])
            )->throw()->json();
        } catch (\Exception) {
            return $this->newPayload(AuthPayload::STATUS_AUTH_FAILED);
        }
        return $this->newPayload(AuthPayload::STATUS_AUTHENTICATED, compact('auth'));
    }
}
