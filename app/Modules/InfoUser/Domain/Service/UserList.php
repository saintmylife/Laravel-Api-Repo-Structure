<?php

namespace App\Modules\InfoUser\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\InfoUser\Repository\InfoUserRepositoryInterface;

/**
 * InfoUserList service
 */
class InfoUserList extends BaseService
{
    private $infoUserRepo;

    public function __construct(InfoUserRepositoryInterface $infoUserRepo)
    {
        $this->infoUserRepo = $infoUserRepo;
    }

    public function __invoke($request)
    {
        $data = $this->infoUserRepo->paginate(isset($request['per_page']) ? $request['per_page'] : 100);
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
