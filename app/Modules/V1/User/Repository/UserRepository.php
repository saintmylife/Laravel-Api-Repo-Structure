<?php

namespace App\Modules\V1\User\Repository;

use Prettus\Repository\Contracts\RepositoryInterface;

interface UserRepository extends RepositoryInterface
{
    public function findEmailOrUsername(string $email);
    public function findForUser(string $credentials);
}
