<?php

namespace App;

use App\Traits\CreatorDetails;

class Taluka extends \Jenssegers\Mongodb\Eloquent\Model
{
    protected $table = 'Taluka';

use CreatorDetails;
    
    protected $fillable=['Name','state_id','district_id','abbr'];

//    public function district()
//    {
//        return $this->belongsTo('App\District');
//    }
//
//    public function State()
//    {
//        return $this->belongsTo('App\State');
//    }
}
