<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organisation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use Auth;
use App\Project;
use Jenssegers\Mongodb\Schema\Builder;
use Illuminate\Database\Schema\Builder as Build;
use Illuminate\Database\Connection;
use Maklad\Permission\Models\Role;
use Maklad\Permission\Models\Permission;
use App\JurisdictionType;
use App\Jurisdiction;
use App\Associate;
use App\ProjectSetupWizard;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $orgs = Organisation::where('orgshow','<>',0)->get();
        return view('admin.organisations.organisation_index',compact('orgs'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.organisations.create_organisation');
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $org=Organisation::create($request->except(['_token']));

       try {
            list($orgId, $dbName) = $this->connectTenantDatabase($org);
            Schema::connection($dbName)->create('jurisdictions', function($table) {
                $table->increments('id');
                $table->string('levelName');
                $table->timestamps();
            });
            Schema::connection($dbName)->create('jurisdiction_types', function($table) {
                $table->increments('id');
                $table->string('jurisdictions');
                $table->timestamps();
            });
            Schema::connection($dbName)->create('locations', function($table) {
                $table->increments('id');
                $table->string('name');
                $table->string('jurisdiction_type_id');
                $table->timestamps();
            });
        } catch(QueryException  $e) {
            DB::setDefaultConnection('mongodb');
            $this->destroy($org->id);
            return redirect()->route('organisation.index')->withMessage('Oganisation Not Created');
        }
        $mongoDBConfig = config('database.connections.mongodb');
        $mongoDBConfig['database'] = $dbName;
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName.'1', $mongoDBConfig);

        Schema::connection($dbName.'1')->create('modules', function($table)
        {
            $table->increments('id');
            $table->string('name');
       });
       Schema::connection($dbName.'1')->create('surveys', function($table)
       {
            $table->increments('id');
            $table->string('name');
            $table->text('json');
            $table->integer('creator_id')->unsigned();
            $table->timestamps();
      });
      Schema::connection($dbName.'1')->create('survey_results', function($table)
      {
            $table->increments('id');
            $table->unsignedInteger('survey_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->text('json');
            $table->timestamps();
     });

     Schema::connection($dbName.'1')->create('projects', function($table)
      {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
     });

     Schema::connection($dbName.'1')->create('categories', function($table)
     {
           $table->increments('id');
           $table->string('name')->unique();
           $table->timestamps();
    });
    
    session()->flash('status', 'Oganisation was created!');
    return redirect()->route('organisation.index');
}

public function getProjects()
{
    $organisationId = Auth::user()->org_id;
    $projects = Organisation::find($organisationIdId);

    list($orgId, $dbName) = $this->connectTenantDatabase($organisationIdId);

    $projects = DB::collection('projects')->get();
    return view('admin.projects.projects_index',compact('projects'));
}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $org=Organisation::find($id);
       return view('admin.organisations.edit',compact('org'));
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
        $org=Organisation::find($id);
        //$org->name=$request->name;
        $org->service=$request->service;
       
        $org->save();

        session()->flash('status', 'Oganisation was updated!');
        return redirect()->route('organisation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $org=Organisation::find($id);
        $dbName = $org->name . '_' . $org->id;
        list($orgId, $dbName) = $this->connectTenantDatabase($id);
        Schema::dropAllTables();
        DB::setDefaultConnection('mongodb');
        DB::table('roles')->where('org_id',$id)->delete();
        DB::table('users')->where('org_id',$id)->delete();
        DB::table('organisations')->where('_id',$id)->delete();
        return redirect()->route('organisation.index')->withMessage('Oganisation Deleted');
    }

    public function orgroles(Request $request,$org_id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase($org_id);
        
		$projectSetupWizard = ProjectSetupWizard::where('org_id',$org_id)->first();		
		
        DB::setDefaultConnection('mongodb');
        $roles=Role::where('org_id', $orgId)->get();	
		
		if ($projectSetupWizard) {	
			if ($projectSetupWizard->org_setup) {
				if (isset($projectSetupWizard->org_setup['projects'])) {
					
					foreach($projectSetupWizard->org_setup['projects'] as $data) {
						
						if ($data['project_setup_status'] == 'Pending') {
							//$request->session()->put('adminAccess', '0');
							$request->session()->put('adminAccessProject', '0');
						}

						if ($data['role_setup_status'] == 'Pending') {
							//$request->session()->put('adminAccess', '0');
							$request->session()->put('adminAccessRole', '0');
						}						
						
					}
					
				}
			}
		}

        return view('admin.organisations.roles_index',compact('roles', 'orgId'));
    }

    public function configureRole(Request $request,$orgId,$role_id)
    {
        $role = Role::find($role_id);
        list($orgId, $dbName) = $this->connectTenantDatabase($orgId);
       
        $modules= DB::collection('modules')->get();
        $projects= DB::collection('projects')->get();

        $roleConfig = DB::collection('role_configs')->where('role_id', $role_id)->first();
        $jurisdictionTypes = JurisdictionType::all();
        $jurisdictionType = '';
        $associate_id = '';

        $role_projects = $role_default_modules = $role_onapprove_modules = $approver_role = array();
        if(isset($roleConfig)){
            $role_projects =  isset($roleConfig['projects'])?$roleConfig['projects']:[];
            $role_default_modules = isset($roleConfig['default_modules'])?$roleConfig['default_modules']:[];
            $role_onapprove_modules = isset($roleConfig['on_approve_modules'])?$roleConfig['on_approve_modules']:[];
            $approver_role = isset($roleConfig['approver_role'])?$roleConfig['approver_role']:[];
            $jurisdictionType = isset($roleConfig['jurisdiction_type_id']) ? $roleConfig['jurisdiction_type_id'] : '';
            $associate_id = isset($roleConfig['associate'])?$roleConfig['associate']:'';
        }     

        $associates = Associate::all();
        
        $jurisdictionName = '';
        if (isset($roleConfig['level'])) {
            $jurisdiction = Jurisdiction::find($roleConfig['level']);
            $jurisdictionName = $jurisdiction !== null ? $jurisdiction->levelName : '';
        } 
        
        DB::setDefaultConnection('mongodb');
        $org_roles=DB::collection('roles')->where('org_id', $orgId)->where('_id','<>',$role_id)->get();
    return view('admin.organisations.role_access',compact('modules','orgId','role','projects','role_default_modules','role_projects','role_onapprove_modules','org_roles','approver_role', 'associates','associate_id','roleConfig','jurisdictionName'/*,'jurisdictionTypes', 'jurisdictionType','jurisdictions'*/));

    }  

    public function updateroleconfig(Request $request,$role_id){

        $data = $request->post();
        $org_id = $data['org_id'];

        DB::collection('roles')->where('_id',$role_id)->update(['project_id' => $data['assigned_projects']]);

        list($orgId, $dbName) = $this->connectTenantDatabase();

        $jurisdiction = Jurisdiction::where('levelName',$data['levelNames'])->first();
		
        $config_data = array('projects' => isset($data['assigned_projects'])?$data['assigned_projects']:'',
                            'default_modules' =>isset($data['default_modules'])?$data['default_modules']:[],
                            'on_approve_modules' =>isset($data['on_approve'])?$data['on_approve']:[],
                            'approver_role' =>isset($data['approver_role'])?$data['approver_role']:[],
                            'associate' =>isset($data['associate'])?$data['associate']:[],
                            'jurisdiction_type_id' => isset($data['jurisdictionId']) ? $data['jurisdictionId'] : '',
                            'associate' => isset($data['associate']) ? $data['associate'] : '',
                            'level' => $jurisdiction->id
                        );
						
        DB::collection('role_configs')->where('role_id', $role_id)
                        ->update($config_data, ['upsert' => true]);
						
		$projectStatus = 'Pending';
		$roleStatus = 'Pending';
		if (isset($data['levelNames']) && $data['levelNames'] != '') {
			$projectStatus = 'Success';
		}

		if ((isset($data['default_modules']) && !empty($data['default_modules'])) 
			&& (isset($data['on_approve']) && !empty($data['on_approve']) && isset($data['approver_role']))) {
			$roleStatus = 'Success';
		}
		if ($roleStatus == 'Success') {
			$projectSetupWizard = ProjectSetupWizard::where(['org_id' => $orgId, 'org_setup.projects.project_id' => $data['assigned_projects'] ])->first();
			
			if ($projectSetupWizard ) {		
				$cnt = 0;
				foreach($projectSetupWizard->org_setup['projects'] as $result) {				
					if ($result['project_id'] == $data['assigned_projects']) {						
						$projectSetupWizard['org_setup.projects.'.$cnt.'.project_setup_status'] = $projectStatus;
						$projectSetupWizard['org_setup.projects.'.$cnt.'.role_setup_status'] = $roleStatus;					
						
						$projectSetupWizard->save();						
						$request->session()->put('adminAccessRole', '1');
						$request->session()->put('adminAccessProject', '1');						
						break;
					}
					$cnt ++;	
				}			
			}
		}
        return redirect()->route('roleconfig', ['orgId' => $org_id, 'role_id' => $role_id])->with('message', 'RoleConfig Updated Successfuly!!!');
    }

    public function getJurisdictionTypesByProjectId(Request $request)
    {
        $projectId = $request->projectId;
        
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $project = Project::find($projectId);
        $jurisTypeId = $project->jurisdiction_type_id;
        
        if (isset($jurisTypeId) && !empty($jurisTypeId)) {
            $jurisdictionTypes = JurisdictionType::find($jurisTypeId);
            return json_encode($jurisdictionTypes);
        }
        return;
    }
}
