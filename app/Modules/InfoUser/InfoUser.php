<?php

namespace App\Modules\InfoUser;

use Illuminate\Database\Eloquent\Model;

class InfoUser extends Model
{
    //
    protected $fillable = [
        'name', 'phone', 'organization_name', 'address', 'quota'
    ];

    public function user()
    {
        return $this->belongsTo('App\Modules\User');
    }
}
