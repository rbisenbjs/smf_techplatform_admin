<?php

namespace App;

use App\Traits\CreatorDetails;

class Cluster extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;
    
    protected $fillable=['Name','state_id','district_id','taluka_id'];

    public function district()
    {
        return $this->belongsTo('App\District');
    }
    public function taluka()
    {
        return $this->belongsTo('App\Taluka');
    }
    public function State()
    {
        return $this->belongsTo('App\State');
    }
}
