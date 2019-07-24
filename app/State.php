<?php 

namespace App;

use App\Traits\CreatorDetails;

class State extends \Jenssegers\Mongodb\Eloquent\Model
{
    protected $table = 'State';

    use CreatorDetails;

    protected $fillable=['Name'];
   
}