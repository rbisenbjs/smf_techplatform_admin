<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Associate;
use Redirect;
use Auth;

class AssociateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $associates = Associate::all();
        return view('admin.associates.associates_index',compact('associates','orgId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
        return view('admin.associates.create_associate',compact('orgId'));
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

        $data = $request->except(['_token']);
        Associate::create($data);

        return redirect()->route('associates.index',['orgId' => $orgId]);
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
    public function edit()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $uri = explode("/",$_SERVER['REQUEST_URI']);
        $associateId = $uri[3];
        $associate = Associate::find($associateId);

        return view('admin.associates.edit',compact('orgId', 'associate'));
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

        $uri = explode("/",$_SERVER['REQUEST_URI']);
        $associateId = $uri[3];

        Associate::where('_id',$associateId)->update(['name'=>$request->name,'type'=>$request->type,'contact_person'=>$request->contact_person,'contact_number'=>$request->contact_number]);

        return redirect()->route('associates.index',['orgId' => $orgId])->withMessage('Associate Updated');;   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $uri = explode("/",$_SERVER['REQUEST_URI']);
        $associateId = $uri[3];
        Associate::find($associateId)->delete();

        return Redirect::back()->withMessage('Associate Deleted');
    }
}
