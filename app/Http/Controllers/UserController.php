<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
#use App\Role;
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

class UserController extends Controller
{
    /**
     * addition of middleware for restricting access
     */
    function __construct(){
        $this->middleware('role:ROOTORGADMIN')->only(['create','edit','store','destroy']);
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
        $users=User::where('is_admin','<>',true)->get();
        // $organisations = Organisation::all();
        
        // return view('admin.users.user_index',compact('organisations'));
        return view('admin.users.user_index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $orgs=Organisation::where('orgshow','<>',0)->get();
        $roles=Role::all();
        // $states=State::all();
        return view('admin.users.create_user',compact(['orgs','roles']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
       
        $validator = Validator::make($request->all(), [
            'phone' => 'unique:users',
            'role_id' => 'required'
        ]
        );
        $errorMessage =
        [
            'unique' => 'User is already registered on Mobile app',
            'required' => 'The :attribute field is required.'
        ];

        if ($validator->fails()) {   
            $failedRules = $validator->failed();      
            if(isset($failedRules['phone']['Unique'])) {
                return Redirect::back()->withErrors(['phone' => $errorMessage['unique']]);
            } else {
                return Redirect::back()->withErrors(['role_id' => $errorMessage['required']]);
            }         
        }
        $dob = $request->dob;
        $dobCarbonObj = new Carbon($dob);
        
        
        $clusters=$villages=$talukas=$districts=array(null);
        $arrayItems=array();
        foreach($_REQUEST as $key=>$value){
            if(is_array($value)){
               array_push($arrayItems,$key);
            }
        }
        foreach($arrayItems as $key=>$value){
           switch($value){
               case 'Cluster': $clusters= $request->Cluster;break;
               case 'Village': $villages= $request->Village;break;
               case 'Taluka': $talukas= $request->Taluka;break;
               case 'District':  $districts= $request->District;break;

           }
        }
              
       
        $states= $request->state_id;
      
         $data= $request->except(['role','_token']);
         $user=User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' =>  bcrypt($data['password']),
            'phone' => $data['phone'],
            'dob' => $dobCarbonObj->getTimestamp(),
            'gender' => $data['gender'],
            'org_id'=>$data['org_id'],
            'role_id'=>$data['role_id'],
            'approved'=> false,
            'is_admin'=> isset($data['is_admin']) ? true : false
        ]);
   
      
        //make an entry in the roles users table
        $role=DB::collection('roles')->where('_id',$data['role_id'])->get();
        $user->assignRole($role[0]['name']);
        UserDetails::create([
            'user_id' => $user['_id'],
            //'state_id' => implode(',', $states),
            'district_id' =>implode(',', $districts),
            'taluka_id' => implode(',', $talukas),
            'village_id' => implode(',', $villages),
            'cluster_id' => implode(',', $clusters),
        
        ]);


        session()->flash('status', 'User was created!');
        return redirect()->route('users.index')->withMessage('User Created');
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
    public function edit($id)
    {
        $user=User::find($id);
        $orgs=Organisation::where('orgshow','<>',0)->get();
        $orgId=$user['org_id'];
        $roleId=$user['role_id'];
        $role=Role::find($roleId);
        
        return view('admin.users.edit',compact(['user','orgs','orgId','role']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {  
        $user=User::find($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->org_id=$request->org_id;
        $user->role_id=$request->role_id;
        if($request->has('approved')){
            $user->approve_status = 'approved';  
        }
        //var_dump($request->all());exit;
        if($request->has('is_admin')){
            $user->is_admin = (bool) $request->is_admin;  
        }else{
            $user->is_admin = false;
        }
        $user->save();

        session()->flash('status', 'User was edited!');
        return redirect()->route('users.index')->withMessage('User Edited');
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
}
