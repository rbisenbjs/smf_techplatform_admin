<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maklad\Permission\Models\Role;
use Maklad\Permission\Models\Permission;
use App\Organisation;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user =Auth::user();	
		
        if($user->hasRole('ROOTORGADMIN')){
           // return view('home');
		    $request->session()->put('userRole', 'ROOTORGADMIN');
		    return view('dashboard');
        } else {
            list($orgId, $dbName) = $this->connectTenantDatabase();
			$request->session()->put('userRole', 'ADMIN');	
            //return view('layouts.userBased',compact('orgId'));
			 return view('dashboard',compact('orgId'));
        }
      
    }
}
