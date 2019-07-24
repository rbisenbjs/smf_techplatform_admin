<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\JurisdictionLevel;

use Validator;
use Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class JurisdictionLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
        //$levelNameData = $request->query('levelNameData');
        $levelNameData = $request->levelNameData;
        $collectionData = DB::table($levelNameData)->get();
        return view('admin.jurisdiction-levels.index', compact(['collectionData', 'levelNameData', 'orgId']));  
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $uri = explode("/",$_SERVER['REQUEST_URI']);
        $levelNameData = $uri[4];
        return view('admin.jurisdiction-levels.create',compact('levelNameData', 'orgId'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $levelNameData = $request->levelNameData;
        $validator = Validator::make($request->all(), ['name' => 'required|unique:'.$levelNameData])->validate();
        
        $district = DB::collection($levelNameData)->insert(
             ['name'=>$request->name]
         );
        session()->flash('status', $levelNameData.' created successfully!');
        return redirect()->route('jurisdictionlevel.index', ['orgId' => $orgId, 'levelNameData' => $levelNameData]);               
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $levelNameData = $request->query('levelNameData');
        $collectionData = DB::table($levelNameData)->where('_id', $id)->first();
        
        return view('admin.jurisdiction-levels.edit',compact('id', 'collectionData','levelNameData','orgId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {    
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $levelNameData = $request->levelNameData;
        $id = $request->recId;
        $validator = Validator::make($request->all(), ['name' => 'required:'.$levelNameData])->validate();
        $district = DB::collection($levelNameData)->where('_id',$id)->update(['name'=>$request->name]);
 
        session()->flash('status', $levelNameData.' edited successfully!');
        return redirect()->route('jurisdictionlevel.index',['orgId' => $orgId, 'levelNameData' => $levelNameData]);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $levelNameData = $request->levelNameData;
        list($orgId, $dbName) = $this->connectTenantDatabase();
        DB::table($levelNameData)->where('_id', '=', $id)->delete();
        session()->flash('status', $levelNameData.' deleted successfully!');
        return redirect()->route('jurisdictionlevel.index', ['orgId' => $orgId, 'levelNameData' => $levelNameData]);                
    }
}
