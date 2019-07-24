<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JurisdictionType;
use App\Organisation;
use App\Location;
use Illuminate\Support\Facades\DB;
use Auth;
use Redirect;
use App\State;
use App\District;
use App\Taluka;
use App\Village;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $modules= DB::collection('modules')->get();

        $jurisdictions= JurisdictionType::all();
;
        return view('admin.locations.index',compact('jurisdictions','orgId'));
    }

    public function get(Request $request)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $jurisdictions = explode(", ",strtolower($request->locationNames));

        $location = Location::where('jurisdiction_type_id',$request->jurisdictionTypeId)->get();
        
        foreach($jurisdictions as $jurisdiction) {
                $jurisdiction = trim($jurisdiction);
                    $location = $location->load($jurisdiction);
        }
            
        return json_encode(['data' => $location ]);
    }

    public function getDetailedLocation(Request $request)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $jurisdictions = explode(", ",$request->locationNames);
        $locationValues = array();

        foreach($jurisdictions as $jurisdiction) {
            $locationValues[strtolower($jurisdiction)] = DB::collection($jurisdiction)->get();
        }

        return json_encode( $locationValues );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        // $request contains _token, jurisdictionTypeId, vlaues of locations: location0,location1,location2,level0_location0, jurisdictionTypes e.g. state,unit, cluster, noOfJurisdictionTypes
        
        list($orgId, $dbName) = $this->connectTenantDatabase();
        DB::setDefaultConnection($dbName);

        $data = $request->all();

        if(isset($request->_id)) {
            $location = Location::find($request->_id);
            $location->jurisdiction_type_id = $request->jurisdiction_type_id;


            $fields = $request->except(['_token',"jurisdiction_type_id","createdBy","location_length",'_id']); 
            
            foreach($fields as $field=>$value)
                $location->$field = $value;
            
            $location->save();

            return Redirect::back()->withMessage('Location was edited!');

            // session()->flash('status', 'Location was edited!');            
            // return redirect()->route('locations.index',['orgId' => $orgId]);
        }

        // {"_token":"TwSVrsiRxuNmkAHta05xRGOFpSMjCtkvtVjsyhRA","jurisdiction_type_id":"5c418fe948b671040c000e36","createdBy":"5c1cb0ce48b67128f4002ea7","location_length":"10","state_id":"5c66989ec7982d31cc6b86c3","district_id":"5c669d72c7982d31cc6b86cf","taluka_id":"5c66a53cd42f283b440013e4"}
        Location::create($data);
        return Redirect::back()->withMessage('Location was created!');

        // session()->flash('status', 'Location was created!');
        // return redirect()->route('locations.index',['orgId' => $orgId]);
    }

	public function deleteLocation(Request $request)
	{
		$this->connectTenantDatabase();
		Location::find($request->id)->delete();
		return json_encode(['status' => 'success']);
	}

}
