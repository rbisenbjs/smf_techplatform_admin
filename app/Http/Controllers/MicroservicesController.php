<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Microservice;
use App\Organisation;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Redirect;
use Session;

class MicroservicesController extends Controller
{
	/**
     * addition of middleware for restricting access
     */
    function __construct(Request $request){
		
       // $this->middleware('role:ROOTORGADMIN')->only(['create','edit','store','destroy']);		
		$this->orgId = Session::get('selectedOrg'); ;
		$this->projectId = Session::get('selectedProject');
		$this->storage_path = storage_path();
		$this->type = "DB";
		$this->errorPath = "Error";
		$data = $this->logInfoData($this->orgId, $this->projectId, 'MicroService', $this->type);		
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $microservices = Microservice::where('is_deleted',0)->get();
        return view('admin.microservices.microservices_index',compact('orgId', 'microservices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        return view('admin.microservices.create_microservice',compact('orgId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createMicroservice(Request $request)
    {
		
		if (trim($request->name) == "" ) {			
			$response_data = array('status' =>'failed','msg' => 'Please enter microservice name', 'code' => 400);					
			return response()->json($response_data);		
			//return Redirect::back()->withErrors(['Please enter microservice name']);			
		}
		
        $validator = Validator::make($request->all(), [
            'name' => 'unique:microservices',
        ]);

        if ($validator->fails()) {            
           // return Redirect::back()->withErrors(['Microservice name already exists']);		   
			$response_data = array('status' =>'failed','msg' => 'Microservice name already exists', 'code' => 400);		
			return response()->json($response_data);	
        }
		
		
        list($orgId, $dbName) = $this->connectTenantDatabase();
       
	    $micCnt = Microservice::where('name', trim($request->name))->count();
		
		if ($micCnt > 0) {
			
			$response_data = array('status' =>'failed','msg' => 'Microservice name already exists', 'code' => 400);		
			return response()->json($response_data);	
		}
       
		$microservice = new Microservice;
		$microservice->name = $request->name;
		$microservice->description = $request->description;
		$microservice->base_url = 'http://13.235.124.3/api';
		$microservice->route = '/forms/result';
		$microservice->is_deleted = 0;
		$microservice->is_active = (bool)$request->active;
		
		$microservice->save();
       
        //session()->flash('status', 'Microservice is created successfully!');		
		$response_data = array('status' =>'success','msg' => 'Microservice is created successfully', 'code' => 200);		
		return response()->json($response_data);
		
       // return redirect()->route('microservice.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editMicroservice(Request $request)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
       $microservice = Microservice::find($request->micId);
		
		return view('admin.microservices.edit', compact('orgId', 'microservice'))->render();

       // return view('admin.microservices.edit',compact('orgId', 'microservice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMicroservice(Request $request)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
		
		
		$micCnt = Microservice::where('name', trim($request->name), '_id', '<>', $request->id)->count();
		
		if ($micCnt > 0) {
			
			$response_data = array('status' =>'failed','msg' => 'Microservice name already exists', 'code' => 400);		
			return response()->json($response_data);
			//return Redirect::back()->withErrors(['Microservice name already exists']);		  			
		}

        $microservice = Microservice::find($request->id);

        $microservice->name = $request->name;
            $microservice->description = $request->description;
           // $microservice->base_url = $request->url;
           // $microservice->route = $request->route;
            $microservice->is_active = (bool)$request->active;
            $microservice->save();
        
       // session()->flash('status', 'Microservice was edited!');
       // return redirect()->route('microservice.index');
	   
	   $response_data = array('status' =>'success','msg' => 'Microservice is updated successfully', 'code' => 200);		
		return response()->json($response_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteMicroservice(Request $request)
    {
		list($orgId, $dbName) = $this->connectTenantDatabase();
        $micrData = Microservice::where('_id',$request->micrId)->first();// print_r($micrData );exit;
		$micrData->is_deleted = 1;
		$micrData->save();
       // return redirect()->route('microservice.index')->withSuccessMessage('State Deleted');
	   
	    $response_data = array('status' =>'success','msg' => 'Microservice is deleted successfully', 'code' => 200);		
		return response()->json($response_data);
    }
}
