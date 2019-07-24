<?php 
namespace App;

//use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\Model;
class Role extends \Jenssegers\Mongodb\Eloquent\Model
{
    protected $fillable=['name','display_name','description','org_id'];
    
}