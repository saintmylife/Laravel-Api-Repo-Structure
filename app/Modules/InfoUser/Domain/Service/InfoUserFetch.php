<?php

namespace App\Modules\InfoUser\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\InfoUser\InfoUserDto;
use App\Modules\InfoUser\Repository\InfoUserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * InfoUser delete
 */
class InfoUserFetch extends BaseService
{
    private $infoUserRepo;

    public function __construct(InfoUserRepositoryInterface $infoUserRepo)
    {
        $this->infoUserRepo = $infoUserRepo;
    }

    public function __invoke(int $id): Payload
    {
        try {
            $data = $this->infoUserRepo->find($id);
            $data->getAllPermissions();
            return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
    }
}
