<?php

namespace App\Modules\Base\Domain\Contracts;

use App\Modules\Base\BaseDto;

interface FilterInterface
{
    /**
     * Get Validation Messages
     */
    public function getMessages();
    /**
     * Default Insert Records
     */
    public function forInsert(BaseDto $data): bool;
    /**
     * Default Update Records
     */
    public function forUpdate(BaseDto $data): bool;
}
