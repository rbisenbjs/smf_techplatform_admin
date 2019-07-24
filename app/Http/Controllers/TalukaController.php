<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Taluka;
use App\District;
use App\State;
use App\Cluster;
use App\Village;
use App\Jurisdiction;
use App\StateJurisdiction;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
use Illuminate\Validation\Rule;

class TalukaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $talukas = Taluka::paginate(5);        
        return view('admin.talukas.talukas_index',compact('talukas'));
    }
    public function getJidandLevel(Request $request){
        $jIdsAndLevel=StateJurisdiction::where('state_id',$request->stateId)->orderBy('level', 'ASC')->get(['jurisdiction_id','level']);
        $levelNames=array();
        if($request->flevel!='')
        foreach ( $jIdsAndLevel as $item){
          
            $jurisdictionName=Jurisdiction::where('_id',$item->jurisdiction_id )->get(['levelName']);
         
           
            if($jurisdictionName[0]->levelName==$request->flevel) return json_encode($levelNames);
            else
            array_push($levelNames, $jurisdictionName[0]->levelName);
          
        }

        else
        if($request->roleLevel!=""){
            foreach ( $jIdsAndLevel as $item){
          
                $jurisdictionName=Jurisdiction::where('_id',$item->jurisdiction_id )->get(['levelName']);
             
               
                if($jurisdictionName[0]->levelName==$request->roleLevel) {
                    array_push($levelNames, $jurisdictionName[0]->levelName);
                    return json_encode($levelNames);
                }
                else
                array_push($levelNames, $jurisdictionName[0]->levelName);
              
            }
        }
        else
        {
            foreach ( $jIdsAndLevel as $item){
          
                $jurisdictionName=Jurisdiction::where('_id',$item->jurisdiction_id )->get(['levelName']);
             
               
                if($jurisdictionName[0]->levelName==$request->flevel)  {
                     array_push($levelNames, $jurisdictionName[0]->levelName);
                 return json_encode($levelNames);
                }
                else
                array_push($levelNames, $jurisdictionName[0]->levelName);
              
            }

        }
        return json_encode($levelNames);
    }
    public function populateData(Request $request){
       
        $tableName="";
        switch($request->item){
            case 'Taluka':$tableName='talukas';break;
            case 'District':$tableName='districts';break;
            case 'Village':$tableName='villages';break;
            case 'Cluster':$tableName='clusters';break;
        }

      
        if($request->district!=''){
          // return json_encode('district : '+$request->district+"\n taluka  : "+$request->taluka+'  State  1 : '+$request->state);
            $res=DB::collection($tableName)->where('district_id',$request->district)->get();
        }
        else
        if($request->taluka!=''){
             // return json_encode('district : '+$request->district+"\n taluka  : "+$request->taluka+'  State  2 : '+$request->state);
            $res=DB::collection($tableName)->where('taluka_id',$request->taluka)->get();
        }
        else 
        if($request->cluster!=''){
           // return json_encode($tableName);
           // return json_encode('cluster : '+$request->cluster+'  State  3 : '+$request->state);
            $res=DB::collection($tableName)->where('cluster_id',$request->cluster)->get();
        }
       else

        $res=DB::collection($tableName)->where('state_id',$request->state)->get();
        return json_encode($res);
    }


   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //to get only those states that have taluka as the jurisdiction level
       $levelId=Jurisdiction::where('levelName','Taluka')->first();

        $stateIds=StateJurisdiction::where('jurisdiction_id',$levelId->id)->get(['state_id']);
        $id=array();
        foreach($stateIds as $stateId){
            $id[]=$stateId->state_id;
        }
    
        $states=State::whereIn('_id',$id)->get();
      
        return view('admin.talukas.create_taluka',compact('states'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $talukas = Taluka::where('Name',$request->talukaName)->where('district_id',$request->District)->get();

        if(!$talukas->isEmpty())
        {
            return Redirect::back()->withErrors(['Taluka already exists']);
        }

        $taluka = new Taluka;
        $taluka->Name = $request->talukaName;
        $taluka->state_id = $request->state_id;
        $taluka->district_id = $request->District;      
        $taluka->save();

        session()->flash('status', 'Taluka was created!');
        return redirect()->route('taluka.index');
        
        // $validator = Validator::make($request->all(), [
        //     'Name' => 'unique:talukas,district_id',
        //     'district_id' => 'unique:talukas,Name',

        //     // 'Name' => Rule::unique('talukas')->where(['Name','=',$request->Name],['state_id','=',$request->district_id])
        // ]);

        // if ($validator->fails()) 
        // {
        //     return Redirect::back()->withErrors(['Taluka already exists']);
        // }
        // $tal = new Taluka;
        // $tal->Name = $request->talukaName;
        // $tal->state_id = $request->state_id;
        // $tal->district_id = $request->District;             
        // $tal->save();
        // return redirect()->route('taluka.index')->withMessage('Taluka Created');
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
        $taluka = Taluka::find($id);
        $states = State::all();
        $districts = District::where('state_id',$taluka->state_id)->get();
        
        return view('admin.talukas.edit',compact('taluka','states','districts'));        
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
        $taluka=Taluka::find($id);
        $taluka->Name=$request->talukaName;
        $taluka->state_id = $request->state_id;
        $taluka->district_id = $request->District;
        $taluka->save();

        $cluster = Cluster::where('state_id',$request->state_id)->get();

        if($cluster->isEmpty())
        {
        Cluster::where('taluka_id',$id)->update(['state_id'=>$request->state_id,'district_id'=>$request->District]); 
        }
        else
        {
            Cluster::where('taluka_id',$id)->delete();
        }

        Village::where('taluka_id',$id)->update(['state_id'=>$request->state_id,'district_id'=>$request->District]);
        
        session()->flash('status', 'Taluka was edited!');
        return redirect()->route('taluka.index');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $taluka=Taluka::find($id)->delete();
        return redirect()->route('taluka.index')->withMessage('Taluka Deleted');                
    }
}
