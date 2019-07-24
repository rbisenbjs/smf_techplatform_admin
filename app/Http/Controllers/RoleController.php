<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
#use App\Role;
#use App\Permission;
use App\Organisation;
use App\Jurisdiction;
use App\RoleJurisdiction;
use App\Survey;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;
use Maklad\Permission\Models\Role;
use Validator;
use Redirect; 
// use Maklad\Permission\Models\Permission;

class RoleController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrgRoles(Request $request)
    {
        $roles=Role::where('org_id', $request->selectedOrg)->get();       
        return json_encode($roles);
    }
    
    public function getRolesOfOrganisation(Request $request)
    {
        $orgId = $request->organisationId;
        $roles = Role::where('org_id',$orgId)->get();

        return json_encode($roles);
    }

    public function index()
    {
        $roles=Role::all();
        // $organisations = Organisation::all();

        // return view('admin.roles.role_index',compact('organisations'));
        return view('admin.roles.role_index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $orgs = Organisation::where('orgshow','<>',0)->get();

        return view('admin.roles.create_role',compact(['orgs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            [ 
                'name' => $request->name.'_'.$request->org_id,
                'org_id' =>$request->org_id 
            ] ,
            [ 
                'name' => 'unique:roles',
                'org_id' => 'required'
            ]
        );

        $errorMessage = [
            'unique' => 'Role already exists',
            'required' => 'Field needs to be filled'
        ];
        if ($validator->fails() ) {      
            $failedRules = $validator->failed();      
            if(isset($failedRules['name']['Unique'])) {
                return Redirect::back()->withErrors(['name' => $errorMessage['unique']]);
            } else {
                return Redirect::back()->withErrors(['org_id' => $errorMessage['required']]);
            }
        }
        
        $project_id = $request->project_id;
        $role = Role::create([
            'name'=>$request->name.'_'.$request->org_id,
            'display_name'=>$request->display_name,
            'description'=>$request->description,
            'org_id'=>$request->org_id,
            'project_id'=>$project_id,
        ]);

        session()->flash('status', 'Role was created!');
        return redirect()->route('role.index')->withMessage('Role Created');
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
    public function edit(Request $request,$id)
    {
         $role = Role::find($id);
         $orgs = Organisation::where('orgshow','<>',0)->get();
         $project_id = '';
         if (isset($role->project_id) && !empty($role->project_id)) {
            $project_id = $role->project_id;
         }
         $org_id = $role->org_id;
         $data['orgID'] = $org_id;
         $request->merge($data);
         $non_ajax_call_flag = true;
         $projects_arr = $this->getAjaxOrgId($request,$non_ajax_call_flag);

         return view('admin.roles.edit',compact(['role','orgs','project_id','projects_arr']));
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
        $role=Role::find($id);
        $role->display_name=$request->display_name;
        $role->description=$request->description;
        $role->org_id=$request->org_id;
        $role->project_id=$request->project_id;
        $role->save();

        session()->flash('status', 'Role was updated!');
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        //validation check to see is users use the role
        $users = User::where('role_id', '=', $id)->get();

        if($users->count() > 0){
            return redirect()->route('role.index')->with('error','Users are assigned to this role');
        }

        $this->connectTenantDatabase($role->org_id);
        $surveys = Survey::where('assigned_roles','=',$id)
                           ->where('isDeleted','=',false)
                           ->get();
        if($surveys->count() > 0){
            return redirect()->route('role.index')->with('error','Forms are assigned to this role');
        }

        $config = DB::collection('role_configs')->where('role_id', $id)->get();
        $role->delete();
        return redirect()->route('role.index')->with('message','Role Deleted Successfuly!');
    }

    public function getAjaxOrgId(Request $request, $non_ajax_call_flag = null)
    {    
        $org_id = $request->orgID;
        list($orgId, $dbName) = $this->connectTenantDatabase($org_id);
        $projects = DB::collection('projects')->get();
        if (isset($non_ajax_call_flag)) {
            return $projects;
        } else {
            return json_encode($projects);
        }
    }

}