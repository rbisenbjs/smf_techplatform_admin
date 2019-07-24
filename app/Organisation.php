<?php

namespace App;

use App\Traits\CreatorDetails;

class Organisation extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    // const CREATED_AT = 'createdDateTime';
    // const UPDATED_AT = 'updatedDateTime';
    
    protected $attributes = ['orgshow' => 1];
    protected $fillable=['name','service'];
}
