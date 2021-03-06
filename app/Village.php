<?php

namespace App;

use App\Traits\CreatorDetails;

class Village extends \Jenssegers\Mongodb\Eloquent\Model
{
    protected $table = 'Village';

    use CreatorDetails;
    
    protected $fillable=['Name','state_id','district_id','taluka_id'];

//    public function district()
//    {
//        return $this->belongsTo('App\District');
//    }
//
//    public function State()
//    {
//        return $this->belongsTo('App\State');
//    }
//    public function taluka()
//    {
//        return $this->belongsTo('App\Taluka');
//    }
//
//    public function cluster()
//    {
//        return $this->belongsTo('App\Cluster');
//    }
}
