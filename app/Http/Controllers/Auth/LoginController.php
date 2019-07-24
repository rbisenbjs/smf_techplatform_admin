<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ProjectSetupWizard;
use App\Project;
use App\Http\Controllers\Auth\Session;
use App\User;
use App\Organisation;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	
	 protected function credentials(Request $request)
    {
		$request->session()->put('adminAccessRole', '1');
		$request->session()->put('adminAccessProject', '1');	
		
        return [
            'email' => $request->{$this->username()},
            'password' => $request->password,
            'is_admin' => true,
        ];
    }
	
	/**
	* Redirect user on the basis of project setting
	* */
	protected function redirectTo() {
		
		$user = Auth::user();
		
		
		//check user loggedin or not		
		if ($user) {

			
			//echo $user->_id;exit;
			$orgData = User::where('_id',$user->_id)->get()->toArray();
			
			//echo '<pre>';print_r($orgData );exit;
			 $temp = [];
			if (count($orgData) > 0) {
				
				foreach ($orgData[0]['orgDetails'] as $data) {					
					$temp[] = $data['org_id'];					
				}
				
			}
			
			if (count($temp) > 0) {
				
				$rogName = Organisation::whereIn('_id',$temp)->select('_id','name')->get();
				$orgData = $rogName->toArray();	
				\Illuminate\Support\Facades\Session::put('orgList', $orgData);				
				\Illuminate\Support\Facades\Session::put('selectedOrg', $orgData[0]['_id']);
				//echo '<pre>';print_r($rogName );exit;
			}
			
			list($orgId, $dbName) = $this->connectTenantDatabase();
			if (count($orgData) > 0) {				
				//$orgData = $orgData->toArray();				
				\Illuminate\Support\Facades\Session::put('selectedProject', $orgData[0]['_id']);
				
				$projects = Project::all();
				
				if ($projects) {				
					$prjData = $projects->toArray();				
					\Illuminate\Support\Facades\Session::put('selectedProject', $prjData[0]['_id']);				
				}	
					
				\Illuminate\Support\Facades\Session::put('projectList', $projects);
			}
		
			$projectSetupWizard = ProjectSetupWizard::where('org_id',$user->org_id)->first();
			//echo '<pre>';	print_r($projectSetupWizard );exit;
		
			if ($projectSetupWizard) {
				
				if ($projectSetupWizard->org_setup) {
					if (isset($projectSetupWizard->org_setup['projects'])) {
						
						foreach($projectSetupWizard->org_setup['projects'] as $data) {
							
							if ($data['project_setup_status'] == 'Pending') {
								//$request->session()->put('adminAccess', '0');
								return '/'.$user->org_id.'/roles';
								
								
							}

							if ($data['role_setup_status'] == 'Pending') {
								//$request->session()->put('adminAccess', '0');
								return '/'.$user->org_id.'/roles'; //.$data['project_id']
							}						
							
						}
						
					}
					
				}	
				
			}		
			return '/'.$user->org_id.'/project/create';
		}
		return '/home';
	}
	
}
