<?php

namespace App\Modules\V1\Role;

use App\Modules\Base\BaseDto;

class RoleDto extends BaseDto
{
    protected $id;
    protected $name;
    protected $guard_name = 'api';
}
