<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cluster;
use App\Taluka;
use App\District;
use App\State;
use App\Village;
use App\Jurisdiction;
use App\StateJurisdiction;
use Validator;
use Redirect;

class ClusterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clusters = Cluster::paginate(5);   
        return view('admin.clusters.clusters_index',compact('clusters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levelId=Jurisdiction::where('levelName','Cluster')->first();
        
        $stateIds=StateJurisdiction::where('jurisdiction_id',$levelId->id)->get(['state_id']);
        $id=array();
        foreach($stateIds as $stateId){
            $id[]=$stateId->state_id;
        }
        
        $states=State::whereIn('_id',$id)->get();
        return view('admin.clusters.create_cluster',compact('states'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clusters = Cluster::where('Name',$request->clusterName)->where('taluka_id',$request->Taluka)->get();

        if(!$clusters->isEmpty())
        {
        return Redirect::back()->withErrors(['Cluster already exists']);
        }
        $cluster = new Cluster;
        $cluster->Name = $request->clusterName;
        $cluster->state_id = $request->state_id;
        $cluster->district_id = $request->District;
        $cluster->taluka_id = $request->Taluka;
        $cluster->save();

        session()->flash('status', 'Cluster was created!');
        return redirect()->route('cluster.index');        
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
        $cluster = Cluster::find($id);
        $states = State::all();
        $districts = District::where('state_id',$cluster->state_id)->get();
        $talukas = Taluka::where('district_id',$cluster->district_id)->get();

        return view('admin.clusters.edit',compact('cluster','states','districts','talukas'));
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
        $cluster=Cluster::find($id);
        $cluster->Name=$request->clusterName;
        $cluster->state_id = $request->state_id;
        $cluster->district_id = $request->District;
        $cluster->taluka_id = $request->Taluka;

        $state=State::find( $cluster->state_id);
        $district=District::find($cluster->district_id);        
        $taluka=Taluka::find( $cluster->taluka_id);

        Village::where('cluster_id',$id)->update(['state_id'=>$request->state_id,'district_id'=>$request->District,'taluka_id'=>$request->Taluka]);

        $cluster->save();

        session()->flash('status', 'Cluster was edited!');
        return redirect()->route('cluster.index');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cluster=Cluster::find($id)->delete();
        return redirect()->route('cluster.index')->withMessage('Cluster Deleted');                
    }
}
