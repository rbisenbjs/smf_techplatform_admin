<?php

namespace App;

use App\Traits\CreatorDetails;

class Microservice extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    // const CREATED_AT = 'createdDateTime';
    // const UPDATED_AT = 'updatedDateTime';
    
    protected $fillable=['name','description','base_url','route','is_active'];
}
