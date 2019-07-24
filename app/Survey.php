<?php
namespace App;

use App\Traits\CreatorDetails;


class Survey extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    // const CREATED_AT = 'createdDateTime';
    // const UPDATED_AT = 'updatedDateTime';
    
    protected $fillable = [
        'name', 'json', 'project_id','category_id','microservice_id','entity_id',//slug',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results()
    {
        return $this->hasMany('App\SurveyResult', 'form_id');
    }
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function microservice()
    {
        return $this->belongsTo('App\Microservice');
    }
    public function entity()
    {
        return $this->belongsTo('App\Entity');
    }
    public function eventTypes()
    {
        return $this->belongsToMany('App\EventType');
    }
}