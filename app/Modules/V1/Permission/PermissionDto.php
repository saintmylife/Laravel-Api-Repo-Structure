<?php

namespace App\Modules\V1\Permission;

use App\Modules\Base\BaseDto;

class PermissionDto extends BaseDto
{
    protected $id;
    protected $name;
    protected $guard_name = 'api';
}
