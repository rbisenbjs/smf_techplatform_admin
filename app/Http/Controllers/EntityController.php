<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity;
use App\Organisation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Validator;
use Redirect;
use Auth;
use Session;

class EntityController extends Controller
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
		$data = $this->logInfoData($this->orgId, $this->projectId, 'Entity', $this->type);		
    }
	
	public function index()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $entities=Entity::all();
        return view('admin.entities.entity_index',compact('entities','orgId'));
    }

    public function create()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        return view('admin.entities.create_entity',compact('orgId'));
    }

    public function store(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'Name' => 'unique:entities,name',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors(['Entity already exists']);
        }

        list($orgId, $dbName) = $this->connectTenantDatabase();

        $entity = new Entity;
        $entity->Name = $request->entityName;
        $entity->display_name = $request->displayName;
        $entity->is_active = (bool)$request->active;
        $entity->save();

        Schema::connection($dbName)->create('entity_'.$entity->id, function($table)
        {
            $table->increments('id');
            $table->string('User ID');
            $table->timestamps();
       });

        return redirect()->route('entity.index')->withMessage('Entity Created');
    }
    public function edit($entity_id)
    {
        // return Entity::find($entity_id);
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $entity = Entity::find($entity_id);
       return view('admin.entities.edit',compact('orgId', 'entity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $entity_id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $entity = Entity::find($entity_id);
        $entity->Name=$request->Name;
        $entity->display_name=$request->display_name;
        $entity->is_active = (bool)$request->active;
        $entity->save();

        return redirect()->route('entity.index')->withMessage('Entity Updated');
    }

    public function destroy($id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $entity = Entity::find($id);
        Schema::drop('entity_'.$id);
        $entity->delete();
        return Redirect::back()->withMessage('Entity Deleted');
    }
	
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createEntity(Request $request)
    {
		//print_r($request->all());exit;
		if (trim($request->entityName) == "" ) {			
			$response_data = array('status' =>'failed','msg' => 'Please enter Entity name', 'code' => 400);					
			return response()->json($response_data);		
			//return Redirect::back()->withErrors(['Please enter microservice name']);			
		}
		 list($orgId, $dbName) = $this->connectTenantDatabase();
		$cnt = Entity::where('Name',trim($request->entityName))->count();
		//echo $cnt;exit;
		if ($cnt > 0) {
			$response_data = array('status' =>'failed',
									'msg' => 'Entity name already exists', 
									'code' => 400);		
			return response()->json($response_data);   
			
		}	
		
       /* $validator = Validator::make($request->all(), [
            'Name' => 'unique:entities,name',
        ]);

        if ($validator->fails()) {            
           // return Redirect::back()->withErrors(['Microservice name already exists']);		   
			$response_data = array('status' =>'failed','msg' => 'Entity name already exists', 'code' => 400);		
			return response()->json($response_data);	
        }*/
		
		
       
       
	    $entity = new Entity;
        $entity->Name = $request->entityName;
        $entity->display_name = $request->displayName;
        $entity->is_active = (bool)$request->active;
		
		try {
			$entity->save();
			
			$success = array('status' =>'success',
							'data' => $request->all(),
							'msg' => 'Enity created successfully',							
							'code' => 200);						
					
			$this->log->info(json_encode($success));

			Schema::connection($dbName)->create('entity_'.$entity->id, function($table)
			{
				$table->increments('id');
				$table->string('User ID');
				$table->timestamps();
			});		
			$response_data = array('status' =>'success','msg' => 'Enity is created successfully', 'code' => 200);		
			return response()->json($response_data);
			
		} catch (Exception $e){
				
			$logPah = "\logs\\".$this->orgId."\\".$this->projectId."\\".$this->modelName."\\". $this->errorPath."\\"."logs_".date('Y-m-d').'.log';
			$this->log->pushHandler(new StreamHandler($this->storage_path.$logPah));
			
			$error = array('status' =>'error',
							'data' => $request->all(),
							'msg' => $e->getMessage(),							
							'code' => 400);						
			$this->log->error(json_encode( $error));
			return response()->json($error);
		}
	}

	public function editEntity(Request $request)  {
		
       list($orgId, $dbName) = $this->connectTenantDatabase();
       $entity = Entity::find($request->entyId);
		
		return view('admin.entities.edit', compact('orgId', 'entity'))->render();

       // return view('admin.microservices.edit',compact('orgId', 'microservice'));
    }

	
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEntity(Request $request)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
		
		
		$micCnt = Entity::where('Name', trim($request->display_name), '_id', '<>', $request->id)->count();
		
		if ($micCnt > 0) {
			
			$response_data = array('status' =>'failed','msg' => 'Microservice name already exists', 'code' => 400);		
			return response()->json($response_data);
			//return Redirect::back()->withErrors(['Microservice name already exists']);		  			
		}
        $entity = Entity::find($request->id);
		
		if ($entity) {

			$entity->Name = $request->name;
			$entity->display_name = $request->display_name;
			$entity->is_active = (bool)$request->active;
			
			try {
				$entity->save();
				
				$success = array('status' =>'success',
							'data' => $request->all(),
							'msg' => 'Enity edited successfully',							
							'code' => 200);						
					
				$this->log->info(json_encode($success));
				
				session()->flash('status', 'Entity edited successfully');
				//return redirect()->route('orgnisationuser.index')->withMessage('User Created');
			
			} catch (Exception $e){
				
				$logPah = "\logs\\".$this->orgId."\\".$this->projectId."\\".$this->modelName."\\". $this->errorPath."\\"."logs_".date('Y-m-d').'.log';
				$this->log->pushHandler(new StreamHandler($this->storage_path.$logPah));
				
				$error = array('status' =>'error',
								'data' => $request->all(),
								'msg' => $e->getMessage(),							
								'code' => 400);						
				$this->log->error(json_encode( $error));
				return response()->json($error);
		}
			
			//session()->flash('status', 'Entity  edited!');
			// return redirect()->route('microservice.index');
	   
			$response_data = array('status' =>'success','msg' => 'Microservice is updated successfully', 'code' => 200);		
			return response()->json($response_data);
		} else {
			
			
		}	
    }

	 /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEntity(Request $request)
    {
		list($orgId, $dbName) = $this->connectTenantDatabase();
        $entityData = Entity::where('_id',$request->entityId)->first();
		
		$entityData->is_deleted = 1;
		
		try {
			
			$entityData->save();	

			$success = array('status' =>'success',
							'data' => $request->all(),
							'msg' => 'Enity deleted successfully',							
							'code' => 200);						
					
			$this->log->info(json_encode($success));			
			session()->flash('status', 'Entity deleted successfully');
			
			$response_data = array('status' =>'success','msg' => 'Entity  deleted successfully', 'code' => 200);		
			return response()->json($response_data);
			
		} catch (Exception $e){
			
				$logPah = "\logs\\".$this->orgId."\\".$this->projectId."\\".$this->modelName."\\". $this->errorPath."\\"."logs_".date('Y-m-d').'.log';
				$this->log->pushHandler(new StreamHandler($this->storage_path.$logPah));
				
				$error = array('status' =>'error',
								'data' => $request->all(),
								'msg' => $e->getMessage(),							
								'code' => 400);						
				$this->log->error(json_encode( $error));
				return response()->json($error);
		} 
    }	
}
