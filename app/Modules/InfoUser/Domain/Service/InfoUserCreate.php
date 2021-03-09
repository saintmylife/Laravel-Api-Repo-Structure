<?php

namespace App\Modules\InfoUser\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\InfoUser\Domain\InfoUserFilter;
use App\Modules\InfoUser\Repository\InfoUserRepositoryInterface;
use App\Modules\InfoUser\InfoUserDto;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/**
 * UserCreate domain
 */
class InfoUserCreate extends BaseService
{
    private $filter;
    private $userRepo;

    public function __construct(InfoUserFilter $filter, InfoUserRepositoryInterface $infoUserRepo)
    {
        $this->filter = $filter;
        $this->infoUserRepo = $infoUserRepo;
    }

    public function __invoke(array $data): Payload
    {

        $userDto = $this->makeDto($data, new InfoUserDto);

        if (!$this->filter->forInsert($userDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }

        $userDto->password = Hash::make($userDto->password);
        $create = $this->userRepo->create($userDto->getData());
        $create->syncRoles($giveRole);


        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
