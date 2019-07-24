<?php

namespace App;

use App\Traits\CreatorDetails;

class Project extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    // const CREATED_AT = 'createdDateTime';
    // const UPDATED_AT = 'updatedDateTime';
    
    protected $fillable = [
        'name',
        'jurisdiction_type_id'
    ];

    public function jurisdiction()
    {
        return $this->belongsTo('App\Jurisdiction');
    }
}
