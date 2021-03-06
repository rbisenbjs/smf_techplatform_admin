<?php

namespace App;

use App\Traits\CreatorDetails;
use App\MachineTracking;
use App\State;
use App\District;

class MachineMou extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    // const CREATED_AT = 'createdDateTime';
    // const UPDATED_AT = 'updatedDateTime';
    
    protected $table = 'machine_mou';

    protected $fillable = [
        'mou_id',
        'machine_type',
        'machine_code',
        'provider_name',
        'ownership_type',
        'provider_trade_name',
        'turnover_less_than_20',
        'gst_number',
        'pan_number',
        'bank_name',
        'branch',
        'ifsc_code',
        'bank_account_number',
        'account_holders_name',
        'account_type',
        'date_of_signing_contract',
        'mou_cancellation',
        'rate1_from',
        'rate1_to',
        'rate1_value',
        'rate2_from',
        'rate2_to',
        'rate2_value',
        'rate3_from',
        'rate3_to',
        'rate3_value'
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
