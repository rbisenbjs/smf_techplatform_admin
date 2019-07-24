<?php
namespace App;

use App\Traits\CreatorDetails;


class ProjectForm extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    protected   $collection = 'form_default_collection';

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    public static function setCollection($collection)
    {
        return new self($collection);
    }
}