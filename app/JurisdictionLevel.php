<?php

namespace App;

use App\Traits\CreatorDetails;

class JurisdictionLevel extends \Jenssegers\Mongodb\Eloquent\Model
{
    //use CreatorDetails;
    //protected $fillable = ['districtName'];
    //protected $table = 'District';
    
    use CreatorDetails;
    protected $fillable = ['name'];
}
