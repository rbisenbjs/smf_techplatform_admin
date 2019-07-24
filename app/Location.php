<?php 

namespace App;

use App\Traits\CreatorDetails;
use App\State;
use App\District;
use App\Taluka;
use App\Village;

class Location extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    // const CREATED_AT = 'createdDateTime';
    // const UPDATED_AT = 'updatedDateTime';
    
    protected $table = 'locations';

    protected $fillable=['jurisdiction_type_id','state_id','district_id','taluka_id','village_id','cluster_id','unit_id','created_by'];


    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function taluka()
    {
        return $this->belongsTo(Taluka::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}