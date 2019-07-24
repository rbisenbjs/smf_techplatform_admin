<?php 

namespace App\Traits;

use Auth;
use Carbon\Carbon;

trait CreatorDetails
{
    public static function boot() {
       
        parent::boot();

//     static::updating(function($table)  {
//         $table->updated_by = Auth::user()->username;
//     });

//     // create a event to happen on deleting
//     static::deleting(function($table)  {
//         $table->deleted_by = Auth::user()->username;
//     });

    // create a event to happen on saving
    static::saving(function($table)  {
        // $table->userName = is_object(Auth::user()) ? Auth::user()->id : 'rootorgadmin'; 
        $table->userName = is_object(Auth::user()) ? Auth::user()->id : 'rootorgadmin';
        $currentTimestamp = Carbon::now()->getTimestamp();
        $table->createdDateTime = $currentTimestamp;
        $table->updatedDateTime = $currentTimestamp; 
    });
    }

    // Auth::user() contains fields -> _id, name, email, phone, dob, gender, org_id, role_id, updated_at, created_at, role_ids, approve_status
}