<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Jurisdiction;
use App\Project;
use App\Organisation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Validator;
use Redirect;
use Auth;
use Session;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class JurisdictionController extends Controller
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
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $juris = Jurisdiction::all();
        return view('admin.jurisdictions.jurisdiction_index',compact('juris','orgId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        return view('admin.jurisdictions.create_jurisdiction', compact('orgId'))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Jurisdiction $juris)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $validator = Validator::make($request->all(), ['levelName' => 'required|unique:jurisdictions'])->validate();

        $juris = new Jurisdiction;
        $juris->levelName = $request->levelName;
        $juris->save();

        Schema::connection($dbName)->create($juris->levelName, function($table)
        {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
       });

        session()->flash('status', 'Jurisdiction was created!');
        return redirect()->route('jurisdictions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $uri = explode("/",$_SERVER['REQUEST_URI']);
        $jurisdicId = $uri[3];
        $jurisData = Jurisdiction::where('_id', $jurisdicId)->get();
        
        foreach ($jurisData as $jrd) {
          //echo $jrd->levelName;exit;
          $controllerName = $jrd->levelName;
          $levelNameData = $jrd->levelName;
        }
        return redirect()->route('jurisdictionlevel.index',['levelNameData'=>$levelNameData]);
        //return view('admin.jurisdiction-levels.index', compact(['collectionData', 'levelNameData', 'orgId']));  
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $juris = Jurisdiction::find($id);
        return view('admin.jurisdictions.edit',compact('orgId', 'juris'));

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
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $validator = Validator::make($request->all(), ['levelName' => 'required'])->validate();
        $juris=Jurisdiction::find($id);
        $juris->id=$request->id;
        $juris->levelName=$request->levelName;
        $juris->save();

        session()->flash('status', 'Jurisdiction was edited!');
        return redirect()->route('jurisdictions.index');   
    }
    
    /**
     * Checks if jurisdiction to be deleted
     * is associated with jurisdiction type
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkJurisdictionTypeExist(Request $request)
    {
        $id = $request->delJurisId;
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $juris = Jurisdiction::find($id);
        $jurisName = $juris->levelName;
        $jurisTypeName = DB::table('jurisdiction_types')->select('jurisdictions')
                         ->whereIn('jurisdictions', [$jurisName])->get();
        $flattened = $jurisTypeName->flatten();
        $flattened->forget(0);

        if (in_array($jurisName,$flattened->all())) {
            return json_encode(array(
                'success' => true,
            ));
        } else {
            return json_encode(array(
                'success' => false,
            ));
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $jurisdiction = Jurisdiction::find($id);
        Schema::drop($jurisdiction->levelName);
        $jurisdiction->delete();

        session()->flash('status', 'Jurisdiction deleted successfully!');
        return redirect()->route('jurisdictions.index');                
    }
}
