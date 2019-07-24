<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Village;
use App\Cluster;
use App\Taluka;
use App\District;
use App\State;
use Validator;
use Redirect;

class VillageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $villages = Village::paginate(5);       
        return view('admin.villages.villages_index',compact('villages')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        $states = State::all();
        $districts = District::all();
        $talukas = Taluka::all();
        $clusters = Cluster::all();
        return view('admin.villages.create_village',compact('states','districts','talukas','clusters'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        if($request->cluster_id == null)
        {
            $villages = Village::where('Name',$request->villageName)->where('taluka_id',$request->Taluka)->get();
        }
        else
        {
            $villages = Village::where('Name',$request->villageName)->where('cluster_id',$request->Cluster)->get();
        }
        if(!$villages->isEmpty())
        {
        return Redirect::back()->withErrors(['Village already exists']);
        }
        $village = new Village;
        $village->Name = $request->villageName;
        $village->state_id = $request->state_id;
        $village->district_id = $request->District;
        $village->taluka_id = $request->Taluka;
       
        if($request->Cluster){
            $village->cluster_id = $request->Cluster;
         }
            $village->save();

        session()->flash('status', 'Village was created!');    
        return redirect()->route('village.index');
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
        $village = Village::find($id);
        $states = State::all();
        $districts = District::where('state_id',$village->state_id)->get();
        $talukas = Taluka::where('district_id',$village->district_id)->get();    
        if($village->cluster_id != null)
            $clusters = Cluster::where('taluka_id',$village->taluka_id)->get();

        return view('admin.villages.edit',compact('village','states','districts','talukas','clusters'));
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
        $village=Village::find($id);
        $village->Name=$request->villageName;
        $village->state_id = $request->state_id;
        $village->district_id = $request->District;
        $village->taluka_id = $request->Taluka;

            if($request->Cluster)
            {
                $village->cluster_id = $request->Cluster;
            }
            else
            {
                $village->cluster_id = null;
            }
        $village->save();

        session()->flash('status', 'Village was edited!');    
        return redirect()->route('village.index');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $village=Village::find($id)->delete();
        return redirect()->route('village.index')->withMessage('Village Deleted');                
    }
}
