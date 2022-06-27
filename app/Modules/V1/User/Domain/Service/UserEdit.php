<?php

namespace App\Modules\V1\User\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\V1\User\Domain\Jobs\HandleAvatarUpload;
use App\Modules\V1\User\Domain\UserFilter;
use App\Modules\V1\User\Repository\UserRepository;
use App\Modules\V1\User\Resources\UserResource;
use App\Modules\V1\User\UserDto;
use Illuminate\Support\Facades\Storage;

class UserEdit extends BaseService
{
    public function __construct(private UserFilter $filter, private UserRepository $repo)
    {
    }

    public function __invoke(array $data): Payload
    {
        if (!$this->filter->forUpdate($data)) {
            $messages = $this->filter->getValidationMessage();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }
        $userDto = new UserDto($this->filter->getValidatedData());

        $update = new UserResource($this->repo->update([
            'name' => $userDto->name,
            'phone' => $userDto->phone,
            'address' => $userDto->address,
        ], auth()->user()->id));

        return $this->newPayload(Payload::STATUS_UPDATED, compact('update'));
    }
}
