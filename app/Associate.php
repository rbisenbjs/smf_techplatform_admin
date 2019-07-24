<?php

namespace App;

use App\Traits\CreatorDetails;

class Associate extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    // const CREATED_AT = 'createdDateTime';
    // const UPDATED_AT = 'updatedDateTime';
    
    protected $fillable = [
        'name',
        'type', // => donor, vendor, partner 
        'contact_number', 
        'contact_person'
    ];
}
