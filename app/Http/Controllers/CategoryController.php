<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Organisation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Validator;
use Redirect;
use Auth;
use Session;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class CategoryController extends Controller
{
	/**
     * addition of middleware for restricting access
     */
    function __construct(Request $request){
		
        // $this->middleware('role:ROOTORGADMIN')->only(['create','edit','store','destroy']);		
		$this->orgId = Session::get('selectedOrg'); ;
		$this->projectId = Session::get('selectedProject');
		$this->storage_path = storage_path();
		$this->type = "DB";
		$this->errorPath = "Error";
		$this->modelName = 'Category';
		$data = $this->logInfoData($this->orgId, $this->projectId, $this->modelName, $this->type);		
    }
	
    public function index()
    {    
        list($orgId, $dbName) = $this->connectTenantDatabase($this->orgId);
        $categories = Category::where(['project_id' => $this->projectId,
									 'is_deleted' => 0])->get();

        return view('admin.categories.categories_index',compact('categories','orgId'));
        
    }

    public function create()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
		$locale = config('locale');

		return view('admin.categories.create_category', compact('orgId', 'locale'))->render();
    }

	/**
     * Create new category for seletced project and org.
     *
     * @param  \Illuminate\Http\Request  $request    
     * @return \Illuminate\Http\Response
     */
    public function savecategory(Request $request) {
		
		/*$orgId = Session::get('selectedOrg'); ;
		$projectId = Session::get('selectedProject');
		$modelName = 'Category';
		$errorPath = 'Error';*/
		$projectId = Session::get('selectedProject');
		$this->log->info(json_encode( $request->all()));
		$errroPath = $this->logErrorPath('Category');
		if (trim($request->name['default']) == '') {
			
			$error = array('status' =>'error',
							'data' => $request->all(),
							'msg' => 'Please enter default value',							
							'code' => 400);	

			//$logPah = "\logs\\".$orgId."\\".$projectId."\\".$modelName."\\". $errorPath."\\"."logs_".date('Y-m-d').'.log';
			$this->log->pushHandler(new StreamHandler($errroPath));
								
			$this->log->error(json_encode( $error));
			
			return response()->json($error);
			
		}
		
		if (strlen(trim($request->name['default'])) > 100) {			
			$error = array('status' =>'error',
							'data' => $request->all(),
							'msg' => 'Please enter only 100 character',							
							'code' => 400);	

			
			$this->log->pushHandler(new StreamHandler($errroPath));					
			$this->log->error(json_encode( $error));
			
			return response()->json($error);
			
		}
		
		list($orgId, $dbName) = $this->connectTenantDatabase();
		
		//check category name exist for selected project
		$catCount = Category::where(['name.default'=>trim($request->name['default']),
									'project_id' =>$projectId])->count();
		
		//$errroPath = $this->logErrorPath('Category');
		if ($catCount > 0) {
			
			$error = array('status' =>'error',
							'data' => $request->all(),
							'msg' => 'Defualt value already exist .',							
							'code' => 400);		
			$this->log->pushHandler(new StreamHandler($errroPath));			
			$this->log->error(json_encode( $error));
			
			return response()->json($error);
			
		}		
        $category = new Category;
        $category->name = $request->name;
        $category->type = $request->categoryType;
		$category->project_id = $projectId;
		$category->is_deleted = 0;
		
		try {			
			$category->save();
			
			$success = array('status' =>'success',
							'data' => $request->all(),
							'msg' => 'Category created successfully',							
							'code' => 200);						
			$this->log->info(json_encode($success));
			
			session()->flash('status', 'Category created successfully');
			
			return response()->json($success);
						
		} catch (Exception $e){
			
			$this->log->pushHandler(new StreamHandler($errroPath));
			
			$error = array('status' =>'error',
							'data' => $request->all(),
							'msg' => $e->getMessage(),							
							'code' => 400);						
			$this->log->error(json_encode( $error));
			return response()->json($error);
		}
    }

    public function edit($category_id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
		$locale = config('locale');
        $category = Category::find($category_id);

       return view('admin.categories.edit',compact('orgId', 'locale', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function update(Request $request, $category_id)
    {
		
        list($orgId, $dbName) = $this->connectTenantDatabase();
		$this->validate(
				$request,
				[
					'name.default' => 'required'
				],
				$this->messages()
		);
        $category = Category::find($category_id);
        $category->name=$request->name;
        $category->type = $request->categoryType;
        $category->save();

        return redirect()->route('category.index')->withMessage('Category Updated');
    }*/

   /* public function destroy($id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
        Category::find($id)->delete();

        return Redirect::back()->withMessage('Category Deleted');
    }*/

	/*public function messages()
	{
		return [
			'name.default.required' => 'English locale name is required.',
			'name.default.unique' => 'English locale name has already been taken.'
		];
	}*/
	
	public function editCategory(Request $request)  {
		
		list($orgId, $dbName) = $this->connectTenantDatabase();
		$locale = config('locale');
		$category = Category::find($request->cateId);

		return view('admin.categories.edit',compact('orgId', 'locale', 'category'))->render();       
    }
	
	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request    
     * @return \Illuminate\Http\Response
     */
    public function updateCategory(Request $request)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();	
		$projectId = \Illuminate\Support\Facades\Session::get('selectedProject');
		$cateCnt = Category::where('_id', '<>', $request->id)
							->where(['name.default'=>trim($request->name['default']) ,
							'project_id' => $projectId])
							->count();		
		if ($cateCnt > 0) {
			
			$response_data = array('status' =>'failed','msg' => 'Default name already exists', 'code' => 400);		
			return response()->json($response_data);
		}
        $category = Category::find($request->id);
		
		if ($category) {
			
			$category->name = $request->name;
			$category->type = $request->categoryType;
			
			try {
				
				$category->save();				
				$success = array('status' =>'success',
							'data' => $request->all(),
							'msg' => 'Category edited successfully',							
							'code' => 200);				
				$this->log->info(json_encode($success));				
				session()->flash('status', 'Category edited successfully');
				
			} catch (Exception $e){
				
				$errroPath = $this->logErrorPath('Category');
				$this->log->pushHandler(new StreamHandler($errroPath));
				
				$error = array('status' =>'error',
								'data' => $request->all(),
								'msg' => $e->getMessage(),							
								'code' => 400);						
				$this->log->error(json_encode( $error));
				return response()->json($error);
			}
			
			$response_data = array('status' =>'success','msg' => 'Category is updated successfully', 'code' => 200);		
			return response()->json($response_data);
			
		} else {
			
			$response_data = array('status' =>'failed',
									'msg' => 'Invalid category Id', 
									'code' => 400);		
			return response()->json($response_data);			
		}	
    }

	 /**
     * Remove the specified category from collection.
     *
     * @param  object $request
     * @return \Illuminate\Http\Response
     */
    public function deleteCategory(Request $request)
    {
		list($orgId, $dbName) = $this->connectTenantDatabase();
        $cateData = Category::where('_id',$request->catId)->first();
		$cateData->is_deleted = 1;
		
		try {
			$cateData->save();
			
			$success = array('status' =>'success',
							'data' => $request->all(),
							'msg' => 'Category deleted successfully',							
							'code' => 200);						
					
			$this->log->info(json_encode($success));			
			session()->flash('status', 'Category deleted successfully');
			
			$response_data = array('status' =>'success','msg' => 'Category  deleted successfully', 'code' => 200);		
			return response()->json($response_data);
			
		
		} catch (Exception $e){

			$errroPath = $this->logErrorPath('Category');
			$this->log->pushHandler(new StreamHandler($errroPath));
			
			$error = array('status' =>'error',
							'data' => $request->all(),
							'msg' => $e->getMessage(),							
							'code' => 400);						
			$this->log->error(json_encode( $error));
			return response()->json($error);
		}       
    }
}