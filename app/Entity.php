<?php

namespace App;

use App\Traits\CreatorDetails;

class Entity extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    // const CREATED_AT = 'createdDateTime';
    // const UPDATED_AT = 'updatedDateTime';

    protected $fillable = [
        'Name','display_name'
    ];
}
