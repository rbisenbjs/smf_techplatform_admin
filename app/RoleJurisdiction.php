<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleJurisdiction  extends \Jenssegers\Mongodb\Eloquent\Model
{
    const CREATED_AT = 'createdDateTime';
    const UPDATED_AT = 'updatedDateTime';

    protected $fillable=['role_id','jurisdiction_id'];       
}
