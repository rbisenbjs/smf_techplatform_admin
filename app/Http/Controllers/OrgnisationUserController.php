<?php

namespace App\Http\Controllers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Http\Request;
use App\User;
use App\Role as UserRole;
use App\Organisation;
use App\RoleJurisdiction;
use App\State;
use App\UserDetails;
use Illuminate\Support\Facades\DB;
use Maklad\Permission\Models\Role;
use Maklad\Permission\Models\Permission;
use Carbon\Carbon;
use Validator;
use Redirect;
use Session;
 

class OrgnisationUserController extends Controller
{
    /**
     * addition of middleware for restricting access
     */
    function __construct(Request $request){
		
        $this->middleware('role:ROOTORGADMIN')->only(['create','edit','store','destroy']);		
		$this->orgId = Session::get('selectedOrg'); ;
		$this->projectId = Session::get('selectedProject');
		$this->storage_path = storage_path();
		$this->type = "DB";
		$this->errorPath = "Error";
		$data = $this->logInfoData($this->orgId, $this->projectId, 'orgUser', $this->type);		
    }


    /**
     * AJAX call handler to populate the states dropdown based on the role selection
     *
     * @return json reponse
     */
    
    public function getLevel(Request $request){
        //get the level for a particular role and based on that level populate the states selection
        $level= RoleJurisdiction::where('role_id',$request->role_id)->get();
        
        $states=DB::collection('state_jurisdictions')->where('jurisdiction_id',$level[0]->jurisdiction_id)->get();
        $stateNames=array();
        foreach ($states as $state){
            $stateName=DB::collection('states')->where('_id',$state['state_id'] )->get();
            array_push($stateNames,$stateName[0]);
        }
       
        $levelName=DB::table('jurisdictions')->where('_id',$level[0]->jurisdiction_id)->get();
        $response=array($levelName[0]['levelName'],$stateNames);
        return json_encode($response);
    }

    public function getUsersOfOrganisation(Request $request)
    {
        $orgId = $request->organisationId;
        $users = User::where('org_id',$orgId)->get();

        return json_encode($users);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//$uri = explode("/",$_SERVER['REQUEST_URI']);				
		//$users = User::where('is_admin','<>',true)->get();
		$orgId = $this->orgId;
		//check user exist or not 
		$users = User::where(['orgDetails.org_id'=> $this->orgId, 
							'orgDetails.project_id'=>  $this->projectId
							])->get();						
							
							
        // $organisations = Organisation::all();
         $roles = UserRole::where('org_id', $this->orgId)->get();    
        
        return view('admin.org-users.user_index',compact('users','orgId','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createuser()
    {
       $orgId = $this->orgId;     
       $roles = Role::where('org_id', $this->orgId)->get();
       
        return view('admin.org-users.create_user',compact(['roles', 'orgId']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveuser(Request $request)
    {    
		//echo '<pre>'; print_r($request->all());exit;
		$orgId = \Illuminate\Support\Facades\Session::get('selectedOrg');
		$projectId = \Illuminate\Support\Facades\Session::get('selectedProject');
		
        /*$validator = Validator::make($request->all(), [
            'phone' => 'unique:users',
            'role_id' => 'required'
        ]
        );*/
       /* $errorMessage =
        [
            'unique' => 'User is already registered on Mobile app',
            'required' => 'The :attribute field is required.'
        ];*/
		
		$this->log->info(json_encode( $request->all()));
		
		$validator = Validator::make($request->all(), [
            'name'  => 'required|max:100',
			'phone' => 'required | max :10',
			'role_id' => 'required',
			'userAddress' => 'required'			
         ]);		 
		 
		if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);

        }
		

        /*if ($validator->fails()) {   
            $failedRules = $validator->failed();      
            if(isset($failedRules['phone']['Unique'])) {
               // return Redirect::back()->withErrors(['phone' => $errorMessage['unique']]);
            } else {
               // return Redirect::back()->withErrors(['role_id' => $errorMessage['required']]);
            }         
        }*/
		
        $dob = $request->dob;
        $dobCarbonObj = new Carbon($dob);
        
        
       /* $clusters=$villages=$talukas=$districts=array(null);
        $arrayItems=array();
        foreach($_REQUEST as $key=>$value){
            if(is_array($value)){
               array_push($arrayItems,$key);
            }
        }
		//echo '<pre>';print_r($arrayItems);exit;
        foreach($arrayItems as $key=>$value){
           switch($value){
               case 'Cluster': $clusters= $request->Cluster;break;
               case 'Village': $villages= $request->Village;break;
               case 'Taluka': $talukas= $request->Taluka;break;
               case 'District':  $districts= $request->District;break;
           }
        }*/
		$data = $request->except(['role','_token']);		
		//echo $data['name'];exit;
		/*$orgDetails [] = ['org_id'=> $orgId,
					'project_id'=> $projectId,
					'role_id'=> $data['role_id'],
					'address'=> $request->userAddress,
					'lat'=> $request->latval,
					'long'=> $request->longval
					];
				
			 $data = $request->except(['role','_token']);
			 $user = User::create([
				'name' => $data['name'],
				'email' => $data['email'],
				'password' =>  bcrypt($data['password']),
				'phone' => $data['phone'],
				'dob' => $dobCarbonObj->getTimestamp(),
				'gender' => $data['gender'],
				'org_id'=> $orgId ,
				'role_id'=>$data['role_id'],
				
				'orgDetails'=> $orgDetails,
				'approved'=> false,
				'is_admin'=> isset($data['is_admin']) ? true : false
			]);*/
        //check user exist or not 
		$userCnt = User::where(['phone'=> $data['phone']])->count();
		
		//echo $userCnt ;exit;
		
		if ($userCnt == 0) {       
			$states = $request->state_id;
		  
			$orgDetails [] = ['org_id'=> $orgId,
					'project_id'=> $projectId,
					'role_id'=> $data['role_id'],
					'address'=> $request->userAddress,
					'lat'=> $request->latval,
					'long'=> $request->longval
					];
					
			 $data = $request->except(['role','_token']);
			
			try {		 
			 
				$user = User::create([
					'name' => $data['name'],
					'email' => $data['email'],
					'password' =>  bcrypt($data['password']),
					'phone' => $data['phone'],
					'dob' => $dobCarbonObj->getTimestamp(),
					'gender' => $data['gender'],
					//'org_id'=>$data['org_id'],
					//'role_id'=>$data['role_id'],
					'orgDetails'=>$orgDetails ,
					'approved'=> false,
					'is_admin'=> isset($data['is_admin']) ? true : false
				]);
				
				$success = array('status' =>'success',
								'data' => $request->all(),
								'msg' => 'User information created successfully',							
								'code' => 200);						
				
				$this->log->info(json_encode( $success));
				
				session()->flash('status', 'User was created!');
				//return redirect()->route('/userlist')->withMessage('User Created');
				// return redirect()->route('userlist',['orgId'=>$orgId]);
				 
				 return redirect()->route('orgnisationuser.index')->withMessage('User created successfully');
			
			
			} catch (Exception $e){
				
				$logPah = "\logs\\".$this->orgId."\\".$this->projectId."\\".$this->modelName."\\". $this->errorPath."\\"."logs_".date('Y-m-d').'.log';
				$this->log->pushHandler(new StreamHandler($this->storage_path.$logPah));
				
				$error = array('status' =>'error',
								'data' => $request->all(),
								'msg' => $e->getMessage(),							
								'code' => 400);						
				$this->log->error(json_encode( $error));				
				return back()->with('msg', "Some error has occured , please try again");
			}
	   
		  
			//make an entry in the roles users table
			/*$role=DB::collection('roles')->where('_id',$data['role_id'])->get();
			$user->assignRole($role[0]['name']);
			UserDetails::create([
				'user_id' => $user['_id'],
				//'state_id' => implode(',', $states),
				'district_id' =>implode(',', $districts),
				'taluka_id' => implode(',', $talukas),
				'village_id' => implode(',', $villages),
				'cluster_id' => implode(',', $clusters),
			
			]);*/		
		} else {
			
			//check user exist or not 
			$userData = User::where(['phone'=> $data['phone'],
									'orgDetails.org_id'=> $orgId, 
									'orgDetails.project_id'=>  $projectId
									])->first();
			
			if ($userData) {
				
				$success = array('status' =>'success',
								'data' => $request->all(),
								'msg' => 'User already exist',							
								'code' => 400);
								
				$this->log->info(json_encode( $success));				
				//return redirect()->route('users.index')->withMessage('User already exist');
				return back()->with('msg', "Some error has occured , please try again");				
			}

			$userData = User::where(['phone'=> $data['phone']])->first();	
			$tempData = $userData->orgDetails;
			
			$orgDetails  = ['org_id'=> $orgId,
					'project_id'=> $projectId,
					'role_id'=> $data['role_id'],
					'address'=> $request->userAddress,
					'lat'=> $request->latval,
					'long'=> $request->longval
					];
			array_push($tempData,$orgDetails);

			$userData->orgDetails = $tempData;
			try {
				$userData->save();
				
				$success = array('status' =>'success',
								'data' => $request->all(),
								'msg' => 'User information created successfully',							
								'code' => 200);						
				
				$this->log->info(json_encode( $success));
				
				session()->flash('status', 'User was created!');
				return redirect()->route('orgnisationuser.index')->withMessage('User Created');
			
				
			} catch (Exception $e){
				
				$logPah = "\logs\\".$this->orgId."\\".$this->projectId."\\".$this->modelName."\\". $this->errorPath."\\"."logs_".date('Y-m-d').'.log';
				$this->log->pushHandler(new StreamHandler($this->storage_path.$logPah));
				
				$error = array('status' =>'error',
								'data' => $request->all(),
								'msg' => $e->getMessage(),							
								'code' => 400);						
				$this->log->error(json_encode( $error));				
				return back()->with('msg', "Some error has occured , please try again");
			}
		}	
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
    public function editUser($id)
    {		
        $user = User::find($id);
		
		if ( $user) {
			
			//ok
			$orgId = \Illuminate\Support\Facades\Session::get('selectedOrg');
			$projectId = \Illuminate\Support\Facades\Session::get('selectedProject');
			
			$roles = Role::where('org_id',$this->orgId)->get();	
			$orgDetails = [];
			$roleId = '';
			if ($user->role_id) {
				$roleId  = $user->role_id;
			}
			
			if ($user->orgDetails) {
				
				foreach ($user->orgDetails as $data) {
				
					if ($data['org_id'] == $orgId && $data['project_id'] ==  $projectId) {
						$orgDetails = $data;
						$roleId = $data['role_id'];
						$role =  Role::find($roleId);						
						break;
					}				
				}
			}
			$role =  Role::find($roleId);			
			return view('admin.org-users.edit',compact(['user','orgId','role','orgDetails','roles','roleId']));
		
		} else {			
			session()->flash('msg', 'User not found');
			return redirect()->route('orgnisationuser.index')->withMessage('User not found');
			
		}
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editData(Request $request)
    {  
		$this->log->info(json_encode( $request->all()));
		
		$validator = Validator::make($request->all(), [
            'name'  => 'required|max:100',
			'phone' => 'required | max :10',
			'role_id' => 'required',
			'userAddress' => 'required',
			'id'=> 'required'
			
         ]);		 
		 
		if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);

        }
		
		$id = $request->id;
		
		$user = User::find($id);
		
        $user->name = $request->name;
        $user->phone = $request->phone;
        //$user->org_id = $request->org_id;
       /// $user->role_id = $request->role_id;
		
        if($request->has('approved')){
            $user->approve_status = 'approved';  
        }
        //var_dump($request->all());exit;
        if($request->has('is_admin')){
            $user->is_admin = (bool) $request->is_admin;  
        } else {
            $user->is_admin = false;
        }
		
		$dob = $request->dob;
		$dobCarbonObj = new Carbon($dob);
		$user->dob = $dobCarbonObj->getTimestamp();
		
		$orgDetails  = [
					'org_id'=> $this->orgId,
					'project_id'=> $this->projectId,
					'role_id'=> $request->role_id,
					'address'=> $request->userAddress,
					'lat'=> $request->latval,
					'long'=> $request->longval
					];
		
		
		if ($user->orgDetails) {
			
			$tempData = $user->orgDetails;
			
			foreach($user->orgDetails as $result) {
				
				if ($result['org_id'] != $this->orgId && $result['project_id'] != $this->projectId) {
					array_push($tempData,$orgDetails);
				}				
			}		
			$user->orgDetails = $tempData;
			
		} else {
			$user->orgDetails = $orgDetails;	
		}		
		
		try {
			$user->save();
			
			$success = array('status' =>'success',
							'data' => $request->all(),
							'msg' => 'User information edited successfully',							
							'code' => 200);						
			
			$this->log->info(json_encode( $success));
			
			session()->flash('status', 'User detail edited  successfully');
			return redirect()->route('users.index')->withMessage('User Edited');
			
		} catch (Exception $e){
			
			$logPah = "\logs\\".$this->orgId."\\".$this->projectId."\\".$this->modelName."\\". $this->errorPath."\\"."logs_".date('Y-m-d').'.log';
			$this->log->pushHandler(new StreamHandler($this->storage_path.$logPah));
			
			$error = array('status' =>'error',
							'data' => $request->all(),
							'msg' => $e->getMessage(),							
							'code' => 400);						
			$this->log->error(json_encode( $error));
			
			return back()->with('msg', "Some error has occured , please try again");

		}
       // session()->flash('status', 'User was edited!');
       // return redirect()->route('orgnisationuser.index')->withMessage('User Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user,$id)
    {
        $user = User::find($id);
        $role_id = $user['role_id'];
        $role = Role::find($role_id);
        
        $user->removeRole($role->name);
        $user->delete();
        session()->flash('status', 'User deleted successfully!');
        return redirect()->route('users.index');
    }
	
	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function inactiveUser(Request $request)
    {
		//echo $request->userId;exit;
		//list($orgId, $dbName) = $this->connectTenantDatabase();
        $userData = User::where('_id',$request->userId)->first();
		
		//print_r($userData );exit;
		
		if ($userData) {
			
			$userData->is_deleted = 1;

			try {
				$userData->save();				
				$success = array('status' =>'success',
								'data' => $request->all(),
								'msg' => 'User information edited successfully',							
								'code' => 200);						
				
				$this->log->info(json_encode( $success));
				
				session()->flash('status', 'User is deleted successfully');				
				return response()->json($success);
				
			} catch (Exception $e){
				
				$logPah = "\logs\\".$this->orgId."\\".$this->projectId."\\".$this->modelName."\\". $this->errorPath."\\"."logs_".date('Y-m-d').'.log';
				$this->log->pushHandler(new StreamHandler($this->storage_path.$logPah));
				
				$error = array('status' =>'error',
								'data' => $request->all(),
								'msg' => $e->getMessage(),							
								'code' => 400);						
				$this->log->error(json_encode( $error));
				
				//return back()->with('msg', "Some error has occured , please try again");
				return response()->json($error);

			}
		}
       // return redirect()->route('microservice.index')->withSuccessMessage('State Deleted');
	   
	    $error = array('status' =>'error',
								'data' => $request->all(),
								'msg' => 'No user found',							
								'code' => 400);						
		$this->log->error(json_encode( $error));				
		
		return response()->json($error);

    }

}
