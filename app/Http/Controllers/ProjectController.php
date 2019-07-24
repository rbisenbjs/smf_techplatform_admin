<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Organisation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Validator;
use Redirect;
use Auth;
use App\JurisdictionType;
use App\ProjectSetupWizard;

class ProjectController extends Controller
{
    public function index()
    {    
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $projects = Project::all();
        return view('admin.projects.projects_index',compact('projects','orgId'));
    }

    public function create(Request $request)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $jurisdictionTypes = JurisdictionType::all();
		
		$projectSetupWizard = ProjectSetupWizard::where('org_id',$orgId)->first();
			
		if (!empty($projectSetupWizard)) {
			$request->session()->put('adminAccessProject', '0');
			$request->session()->put('adminAccessRole', '0');
		}
        return view('admin.projects.create_project',compact('orgId', 'jurisdictionTypes'));
    }

    public function store(Request $request)
    { 
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $result = $request->validate([
            'name' => 'required|unique:projects',
            'jurisdictionType' => 'required'
        ]);

        $projectId = DB::collection('projects')->insertGetId(
            [
            'name'=>$result['name'],
            'jurisdiction_type_id'=>$result['jurisdictionType'],
            'userName'=>Auth::user()->id
            ]
        );		
		//$orgId = "testData";
		$projectSetupWizard = ProjectSetupWizard::where('org_id',$orgId)->first();
	
		if ($projectSetupWizard) {				
			if (isset($projectSetupWizard->org_setup['projects'])) {				
				
				$rawData = $projectSetupWizard->org_setup['projects'];
				$projectData = [];				
				$prjDetails['project_id'] = (string) $projectId;
				$prjDetails['project_setup_status'] = 'Pending';
				$prjDetails['role_setup_status'] = 'Pending';
				$finalData = array_push($rawData ,$prjDetails);					
				$projectData['projects'] = ($rawData);
				$projectSetupWizard->org_setup =  ($projectData);				
				$projectSetupWizard->save(); 		
			}
			
		} else {
			
			$projectData = [];
			$projects = array();
			$project = new ProjectSetupWizard;
			$project->org_id = $orgId;			
			$prjDetails['project_id'] = '1234';
			$prjDetails['project_setup_status'] = 'Pending';
			$prjDetails['role_setup_status'] = 'Pending';
			$projects = $prjDetails;
			$projectData['projects'] = array( $prjDetails);

			$project->org_setup =  ($projectData);	

				
			$project->save(); 

		}	
		
		if ($request->session()->get('adminAccessRole') == 0) {
			
			return redirect()->route('rolesuser', ['orgId' => $orgId])->withMessage('project Created');
			
		}	

        return redirect()->route('project.index')->withMessage('project Created');
    }
    public function edit($project_id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $project = Project::find($project_id);
        $jurisdictionTypes = JurisdictionType::all();
        
       return view('admin.projects.edit',compact('orgId', 'project', 'jurisdictionTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project_id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $result = $request->validate([
            'name' => 'required',
            'jurisdictionType' => 'required'
        ]);

        $project = DB::collection('projects')->where('_id',$project_id)->update(
            [
            'name'=>$result['name'],
            'jurisdiction_type_id'=>$result['jurisdictionType']
            ]
        );
        return redirect()->route('project.index')->withMessage('Project Updated');
    }

    public function destroy($id)
    {
        DB::table('roles')->where('project_id',$id)->update(['project_id' => null]);
        $this->connectTenantDatabase();
        Project::find($id)->delete();
        return Redirect::back()->withMessage('Project Deleted');
    }
}
