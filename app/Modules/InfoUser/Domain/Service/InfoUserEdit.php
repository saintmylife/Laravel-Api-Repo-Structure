<?php

namespace App\Modules\InfoUser\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\InfoUser\Domain\InfoUserFilter;
use App\Modules\InfoUser\Repository\InfoUserRepositoryInterface;
use App\Modules\InfoUser\InfoUserDto;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

/**
 * InfoUserEdit service
 */
class InfoUserEdit extends BaseService
{
    private $filter;
    private $infoUserRepo;

    public function __construct(InfoUserFilter $filter, InfoUserRepositoryInterface $infoUserRepo)
    {
        $this->filter = $filter;
        $this->infoUserRepo = $infoUserRepo;
    }

    public function __invoke(int $id, array $data): Payload
    {
        $infoUserDto = $this->makeDto($data, new InfoUserDto);
        $infoUserDto->id = $id;
        if (!$this->filter->forUpdate($infoUserDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        try {
            $this->infoUserRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }

        $dataForDb = $infoUserDto->getData();
        if (is_null($infoUserDto->password)) {
            unset($dataForDb['password']);
        } else {
            $dataForDb['password'] = Hash::make($dataForDb['password']);
        }

        $update = $this->infoUserRepo->update($dataForDb, $id);
        if (!is_null($update)) {
            $update->syncRoles($infoUserDto->roles);
        }

        return $this->newPayload(Payload::STATUS_UPDATED, compact('data'));
    }
}
