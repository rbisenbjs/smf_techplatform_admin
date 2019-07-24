<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/','PagesController@index');

Route::get('/about','PagesController@about');

Route::get('/services','PagesController@services');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(
    ['middleware'=>'auth'],
    function(){
    Route::get('/admin',
    ['as'=>'admin.index',
     'uses'=> function(){
        return view('admin.index');
    }
   ]);
    Route::resource('role','RoleController');
    Route::delete('role/{id}', array('as' => 'role.destroy','uses' => 'RoleController@destroy'));
    Route::resource('organisation','OrganisationController');
    Route::resource('{orgId}/reports','ReportController');
    Route::resource('users','UserController');
    Route::delete('user/{id}', array('as' => 'user.destroy','uses' => 'UserController@destroy'));
    
    Route::resource('/jurisdictionlevel','JurisdictionLevelController');
    Route::get('jurisdictionlevel/{levelNameData}', array('uses'=>'JurisdictionLevelController@index'));
    Route::get('{orgId}/jurisdictionlevel/create/{levelNameData}','JurisdictionLevelController@create');
    Route::post('jurisdictionlevel/store','JurisdictionLevelController@store');
    Route::delete('/jurisdictionlevel/{id}', array('uses' => 'JurisdictionLevelController@destroy'));

    Route::resource('orgManager','orgManager');
    Route::get('{org_id}/{module_id}','ModuleManagerController@getModuleData')->where(['org_id' => '[0-9]+', 'module_id' => '[0-9]+']);
    Route::get('{orgId}/forms/create', 'SurveyController@showCreateForm');

    Route::post('/savebuiltform','SurveyController@saveSurveyForm');
    Route::get('/{orgId}/setKeys/{survey_id}','SurveyController@setKeys');
    Route::post('/form/storeKeys','SurveyController@storeKeys');
    Route::get('/{orgId}/editKeys/{survey_id}','SurveyController@editKeys');
    Route::get('{orgId}/forms','SurveyController@index');
    Route::get('{orgId}/roles',['as'=>'rolesuser','uses'=>'OrganisationController@orgroles']);
    Route::get('{orgId}/roles/{role_id}',['as'=>'roleconfig','uses'=>'OrganisationController@configureRole']);
    Route::post('/updateroleconfig/{role_id}','OrganisationController@updateroleconfig');

    Route::post('{orgId}/{id}/getSurvey','SurveyController@display');
    Route::post('{orgId}/{id}/results','SurveyController@viewResults');

    Route::get('/{orgId}/{surveyId}/sendResponse','SurveyController@sendResponse');
    Route::get('/projects','OrganisationController@getProjects');

    Route::get('/{orgID}/editForm/{surveyID}','SurveyController@editForm');
    Route::resource('form','SurveyController');
    Route::post('/saveEditedform','SurveyController@saveEditedForm');
	Route::post('/editFormData','SurveyController@editFormData');
	
	Route::post('/setProject','SurveyController@setProject');
	
	
    Route::resource('entity','EntityController');
    Route::get('{orgId}/entities','EntityController@index');
  //  Route::get('{orgId}/entity/create','EntityController@create');
	
	
	Route::post('/createEntity','EntityController@createEntity');
	Route::post('/editEntity','EntityController@editEntity');
	Route::post('/updateEntity','EntityController@updateEntity');
	Route::post('/deleteEntity','EntityController@deleteEntity');
	
	
    Route::resource('microservice','MicroservicesController');
    Route::get('{orgId}/microservices','MicroservicesController@index');
	Route::post('/createMicroservice','MicroservicesController@createMicroservice');
	Route::post('/editMicroservice','MicroservicesController@editMicroservice');
	Route::post('/updateMicroservice','MicroservicesController@updateMicroservice');
	Route::post('/deleteMicroservice','MicroservicesController@deleteMicroservice');

    Route::resource('category','CategoryController');
    Route::get('{orgId}/categories','CategoryController@index');
    Route::post('/category/create','CategoryController@create');
	Route::post('/storecategory','CategoryController@savecategory');
	Route::post('/editCategory','CategoryController@editCategory');
	Route::post('/updateCategory','CategoryController@updateCategory');
	Route::post('/deleteCategory','CategoryController@deleteCategory');

    
    Route::resource('event-type','EventTypeController');
    Route::get('{orgId}/event-types',['as'=>'event-types.index','uses'=>'EventTypeController@index']);
    Route::get('{orgId}/event-type/create','EventTypeController@create');
	
	Route::post('/eventTypes','EventTypeController@addEventtype');
	Route::post('/saveEtype','EventTypeController@saveEtype');
	Route::post('/editEtype','EventTypeController@editEtype');
	Route::post('/updateEtype','EventTypeController@updateEtype');
	Route::post('/deleteEtype','EventTypeController@deleteEtype');


    Route::resource('project','ProjectController');
    Route::get('{orgId}/projects','ProjectController@index');
    Route::get('{orgId}/project/create','ProjectController@create');

    Route::post('{orgId}/locations','LocationController@store');
    Route::get('{orgId}/locations','LocationController@index');
    // , [
    //     'parameters' => ['location' => 'locationId'],
    // ]);  

    Route::resource('jurisdictions','JurisdictionController');
    Route::get('{orgId}/jurisdictions','JurisdictionController@index');
   
    Route::post('/jurisdiction/create','JurisdictionController@create');
    Route::get('{orgId}/jurisdictions/{id}','JurisdictionController@show');
    Route::delete('jurisdictions/{id}', array('as' => 'jurisdictions.destroy','uses' => 'JurisdictionController@destroy'));
    Route::resource('{orgId}/jurisdiction-types', 'JurisdictionTypeController')->except(['show']);
    Route::resource('{orgId}/associates','AssociateController', [
        'parameters' => ['associate' => 'associateId'],
    ]);
    Route::resource('{orgId}/modules', 'ModuleController')->except(['show']);	
	
	//org user routes
	Route::resource('orgnisationuser','OrgnisationUserController');	
	Route::post('store','OrgnisationUserController@saveuser');
	Route::get('editUser/{id}','OrgnisationUserController@editUser');	
	Route::resource('{orgId}/userlist','OrgnisationUserController');
	Route::get('{orgId}/addUser','OrgnisationUserController@createuser');
	Route::post('/deleteUser','OrgnisationUserController@inactiveUser');	
	Route::post('editUserData','OrgnisationUserController@editData');
	
    Route::delete('orguser/{id}', array('as' => 'orguser.destroy','uses' => 'OrgnisationUserController@destroy'));
});


Route::group(['middleware' => [CheckAuth::class]], function () { 
    Route::get('/getRoles','RoleController@getOrgRoles');
    Route::get('/getJurisdiction','StateController@getJurisdiction');
    Route::get('/getLevel','UserController@getLevel');
    Route::get('/getJidandLevel','TalukaController@getJidandLevel');
    Route::get('/populateData','TalukaController@populateData');
    Route::get('/getAjaxOrgId','RoleController@getAjaxOrgId');
    Route::get('/checkJurisdictionTypeExist','JurisdictionController@checkJurisdictionTypeExist');
    Route::get('/getJurisdictionTypesByProjectId','OrganisationController@getJurisdictionTypesByProjectId');
    Route::get('/getLocations', 'LocationController@get');
    Route::get('/getDetailedLocation','LocationController@getDetailedLocation');
    Route::get('/getUsersOfOrganisation','UserController@getUsersOfOrganisation');
    Route::get('/getRolesOfOrganisation','RoleController@getRolesOfOrganisation');
	Route::post('/deleteLocation', 'LocationController@deleteLocation');

});

Route::get('/settings', 'SettingsController@index')->name('settings');
Route::get('/sendOTP','smsAuthController@sendOTP');
Route::get('/verifyOTP','smsAuthController@verifyOTP');
Route::get('/getTestEndpoint','smsAuthController@getTestEndpoint');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});