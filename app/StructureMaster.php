<?php

namespace App;

use App\Traits\CreatorDetails;
use App\State;
use App\District;
use App\Taluka;
use App\Village;

class StructureMaster extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    // const CREATED_AT = 'createdDateTime';
    // const UPDATED_AT = 'updatedDateTime';

    protected $fillable = [
        'structure_code',
        'structure_name',
        'structure_owner_department',
        'structure_owner_department_sub_type',
        'structure_type',
        'number_of_catchment_villages',
        'village_population'
    ];

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
