<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\District;
use App\State;
use App\Taluka;
use App\Cluster;
use App\Village;
use Validator;
use Redirect;
use Illuminate\Validation\Rule;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districts = District::paginate(5);
        return view('admin.districts.districts_index',compact('districts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::all();
        return view('admin.districts.create_district',compact('states'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $districts = District::where('Name',$request->districtName)->where('state_id',$request->state_id)->get();

        if(!$districts->isEmpty())
        {
            return Redirect::back()->withErrors(['District already exists']);
        }

        $district = new District;
        $district->Name = $request->districtName;
        $district->state_id = $request->state_id;
        $district->save();

        session()->flash('status', 'District was created!');
        return redirect()->route('district.index');               
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
        $district = District::find($id);
        $states = State::all();

        return view('admin.districts.edit',compact('district','states'));
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
        
        $district=District::find($id);
        $district->Name=$request->districtName;        
        $district->state_id=$request->state_id;
        $district->save();

        Taluka::where('district_id',$id)->update(['state_id'=>$request->state_id]);
        $cluster = Cluster::where('state_id',$request->state_id)->get();

        if($cluster->isEmpty())
        {
        Cluster::where('district_id',$id)->update(['state_id'=>$request->state_id]); 
        }
        else
        {
            Cluster::where('district_id',$id)->delete();
        }
        Village::where('district_id',$id)->update(['state_id'=>$request->state_id]);

        session()->flash('status', 'District was edited!');
        return redirect()->route('district.index');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $district=District::find($id)->delete();
        return redirect()->route('district.index')->withMessage('District Deleted');                
    }
}
