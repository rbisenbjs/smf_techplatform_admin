<?php

namespace App\Http\Controllers;

use App\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $modules = Module::all();
        return view('admin.modules.index', compact('orgId', 'modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
		$locale = config('locale');
        return view('admin.modules.create', compact('orgId', 'locale'));
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
		$this->validate(
			$request,
			[
				'name.default' => 'required|unique:modules'
			], [
				'name.default.required' => 'English locale name is required.',
				'name.default.unique' => 'English locale name has already been taken.'
			]
		);
        $module = new Module;
		$module->name = $request->name;
		$module->save();
        return redirect()->route(
                    'modules.index',
                    ['orgId' => $orgId]
                )->with('status', 'Module has been created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $orgId
     * @param string $module
     * @return \Illuminate\Http\Response
     */
    public function edit($orgId, $module)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase($orgId);
		$locale = config('locale');
        $module = Module::find($module);
        return view('admin.modules.edit', compact('orgId', 'locale', 'module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $orgId
     * @param  string  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $orgId, $module)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase($orgId);
		$this->validate(
			$request,
			[
				'name.default' => 'required'
			], [
				'name.default.required' => 'English locale name is required.'
			]
		);
        $module = Module::find($module);
		$module->name = $request->name;
		$module->update();
        return redirect()->route(
                    'modules.index',
                    ['orgId' => $orgId]
                )->with('status', 'Module has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $orgId
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy($orgId, $module)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase($orgId);

        Module::find($module)->delete();
        return back()->with('status', 'Module has been deleted successfully.');
    }
}
