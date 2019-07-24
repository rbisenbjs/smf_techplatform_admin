<?php

namespace App;

use App\Traits\CreatorDetails;

class smsAuth extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    // const CREATED_AT = 'createdDateTime';
    // const UPDATED_AT = 'updatedDateTime';
    
    protected $fillable=['phone','otp'];

}
