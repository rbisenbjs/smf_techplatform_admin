<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organisation;
use App\EventType;
use App\Survey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Validator;
use Redirect;
use Auth;
use Session;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class EventTypeController extends Controller
{
	
	function __construct(Request $request){
		
        // $this->middleware('role:ROOTORGADMIN')->only(['create','edit','store','destroy']);		
		$this->orgId = Session::get('selectedOrg'); ;
		$this->projectId = Session::get('selectedProject');
		$this->storage_path = storage_path();
		$this->type = "DB";
		$this->errorPath = "Error";
		$this->modelName = 'Event-Type';
		$data = $this->logInfoData($this->orgId, $this->projectId, $this->modelName, $this->type);		
    }
	
	
    public function index()
    {    
        list($orgId, $dbName) = $this->connectTenantDatabase($this->orgId);
        
		$event_types = EventType::where(['project_id' => $this->projectId,
										'is_deleted' => 0])
										->get();
		
        return view('admin.event_types.index',compact('event_types','orgId'));
        
    }

    public function addEventtype()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase($this->orgId);
		
        $forms = Survey::where('active','true')->get();
		
        return view('admin.event_types.create',compact('orgId', 'forms'))->render();
    }

    public function saveEtype(Request $request)
    {
        /*list($orgId, $dbName) = $this->connectTenantDatabase();
		
				
		$orgId = Session::get('selectedOrg'); ;
		$projectId = Session::get('selectedProject');
		$modelName = 'Category';
		$errorPath = 'Error';*/
		$projectId = Session::get('selectedProject');
		
		$this->log->info(json_encode( $request->all()));
		$errroPath = $this->logErrorPath('Category');
		
		$name = trim($request->name);
		
		if ($name == '') {
			
			$error = array('status' =>'error',
							'data' => $request->all(),
							'msg' => 'Please enter event type value',							
							'code' => 400);	

			$this->log->pushHandler(new StreamHandler($errroPath));								
			$this->log->error(json_encode( $error));
			
			return response()->json($error);
			
		}
		
		if (strlen($name) > 100) {			
			$error = array('status' =>'error',
							'data' => $request->all(),
							'msg' => 'Please enter only 100 character',							
							'code' => 400);	
							
			$this->log->pushHandler(new StreamHandler($errroPath));					
			$this->log->error(json_encode( $error));
			
			return response()->json($error);
			
		}
		
		list($orgId, $dbName) = $this->connectTenantDatabase();
		
		//check category name exist for selected project
		$catCount = EventType::where(['name'=>$name,
									'project_id' =>$projectId])->count();
		
		$errroPath = $this->logErrorPath('Event-Type');
		if ($catCount > 0) {
			
			$error = array('status' =>'error',
							'data' => $request->all(),
							'msg' => 'Event type name already exist .',							
							'code' => 400);		
			$this->log->pushHandler(new StreamHandler($errroPath));			
			$this->log->error(json_encode( $error));
			
			return response()->json($error);
			
		}		
        $event_type = new EventType;
        $event_type->name = $name;
        $event_type->project_id = $projectId;
		$event_type->is_deleted = 0;
		
		try {
			
			$event_type->save();
			
			if (isset($request->associatedForms)){
				$event_type->surveys()->attach($request->associatedForms);
			} else {
				$event_type->survey_ids = [];
				$event_type->save();
			}		
			$success = array('status' =>'success',
							'data' => $request->all(),
							'msg' => 'Event Type created successfully',							
							'code' => 200);						
			$this->log->info(json_encode($success));
			
			session()->flash('status', 'Event Type created successfully');
			
			return response()->json($success);
						
		} catch (Exception $e){
			
			$this->log->pushHandler(new StreamHandler($errroPath));
			
			$error = array('status' =>'error',
							'data' => $request->all(),
							'msg' => $e->getMessage(),							
							'code' => 400);						
			$this->log->error(json_encode( $error));
			return response()->json($error);
		}
	}

    public function editEtype(Request $request)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $event_type = EventType::find($request->etypeId);
        $forms = Survey::where('active','true')->get();

       return view('admin.event_types.edit',compact('orgId', 'event_type','forms'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $event_type_id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
		$this->validate(
				$request,
				[
					'name' => 'required'
				],
				$this->messages()
		);
        $event_type = EventType::find($event_type_id);
        $event_type->name = $request->name;
        $event_type->surveys()->sync($request->associatedForms);
        #$event_type->associatedForms = $request->associatedForms;
        $event_type->save();

        return redirect()->route('event-types.index',$orgId)->withMessage('Event Type Updated');
    }
	
	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request    
     * @return \Illuminate\Http\Response
     */
    public function updateEtype(Request $request)
    {
		$name = trim($request->name);
		$this->log->info(json_encode( $request->all()));
		$errroPath = $this->logErrorPath('Category');
		
		if ($name == '') {
			
			$error = array('status' =>'error',
							'data' => $request->all(),
							'msg' => 'Please enter event type value',							
							'code' => 400);	

			$this->log->pushHandler(new StreamHandler($errroPath));								
			$this->log->error(json_encode( $error));
			
			return response()->json($error);
			
		}
		
		if (strlen($name) > 100) {			
			$error = array('status' =>'error',
							'data' => $request->all(),
							'msg' => 'Please enter only 100 character',							
							'code' => 400);	
							
			$this->log->pushHandler(new StreamHandler($errroPath));					
			$this->log->error(json_encode( $error));
			
			return response()->json($error);
			
		}

        list($orgId, $dbName) = $this->connectTenantDatabase();
		
		$projectId = \Illuminate\Support\Facades\Session::get('selectedProject');
		$etypeCnt = EventType::where('_id', '<>', $request->id)
							->where(['name'=>$name,
							'project_id' => $projectId])
							->count();		
		if ($etypeCnt > 0) {
			
			$response_data = array('status' =>'failed','msg' => 'Event Type name already exists', 'code' => 400);		
			return response()->json($response_data);
		}
        $eType = EventType::find($request->id);
		
		if ($eType) {
			
			$eType->name = $name;
			$eType->surveys()->sync($request->associatedForms);
			
			try {
				
				$eType->save();				
				$success = array('status' =>'success',
							'data' => $request->all(),
							'msg' => 'Event Type edited successfully',							
							'code' => 200);				
				$this->log->info(json_encode($success));				
				session()->flash('status', 'Event Type edited successfully');
				
			} catch (Exception $e){
				
				$errroPath = $this->logErrorPath('Event-Type');
				$this->log->pushHandler(new StreamHandler($errroPath));
				
				$error = array('status' =>'error',
								'data' => $request->all(),
								'msg' => $e->getMessage(),							
								'code' => 400);						
				$this->log->error(json_encode( $error));
				return response()->json($error);
			}
			
			$response_data = array('status' =>'success','msg' => 'Event Type is updated successfully', 'code' => 200);		
			return response()->json($response_data);
			
		} else {
			
			$response_data = array('status' =>'failed',
									'msg' => 'Invalid Event Type Id', 
									'code' => 400);		
			return response()->json($response_data);			
		}	
    }


    public function destroy($id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $event_type = EventType::find($id);
        $event_type->surveys()->sync([]);
        $event_type->delete();
        return Redirect::back()->withMessage('Event Type Deleted');
    }

	 /**
     * Remove the specified category from collection.
     *
     * @param  object $request
     * @return \Illuminate\Http\Response
     */
    public function deleteEtype(Request $request)
    {
		list($orgId, $dbName) = $this->connectTenantDatabase();
        $eventType = EventType::where('_id',$request->etypeId)->first();
		$eventType->is_deleted = 1;
		
		try {
			$eventType->save();
			
			$success = array('status' =>'success',
							'data' => $request->all(),
							'msg' => 'Event Type deleted successfully',							
							'code' => 200);						
					
			$this->log->info(json_encode($success));			
			session()->flash('status', 'Event Type deleted successfully');
			
			$response_data = array('status' =>'success','msg' => 'Event Type  deleted successfully', 'code' => 200);		
			return response()->json($response_data);
			
		
		} catch (Exception $e){

			$errroPath = $this->logErrorPath('Event-Type');
			$this->log->pushHandler(new StreamHandler($errroPath));
			
			$error = array('status' =>'error',
							'data' => $request->all(),
							'msg' => $e->getMessage(),							
							'code' => 400);						
			$this->log->error(json_encode( $error));
			return response()->json($error);
		}       
    }
}
