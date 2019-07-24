<?php

namespace App;

use App\Traits\CreatorDetails;

class ProjectSetupWizard extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    protected $table = 'org_project_setup_wizard';

   /* protected $fillable = [
        'org_id'
    ];*/
}