<?php

namespace App;

use App\Traits\CreatorDetails;
use App\State;
use App\District;
use App\Taluka;

class MachineMaster extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    // const CREATED_AT = 'createdDateTime';
    // const UPDATED_AT = 'updatedDateTime';
    
    protected $fillable = [
        'machine_code',
        'make_and_model',
        'rto_number',
        'chassis_number',
        'provider_name',
        'providers_contact',
        'ownership_type',
        'provider_trade_name',
        'turnover_less_than_20',
        'gst_number',
        'pan_number',
        'bank_details',
        'excavation_capacity_per_hour',
        'diesel_tank_capacity_in_litres',
        'mou_id',
        'date_of_signing_contract',
        'mou_cancellation',
		'owned_by_bjs'
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

}
