<?php
namespace App;

use App\Traits\CreatorDetails;
use App\EventType;

class Event extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    
    protected $fillable = [];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event_type()
    {
        return $this->belongsTo('App\EventType');
    }
}