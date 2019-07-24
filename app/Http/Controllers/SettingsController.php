<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth');
    }

    public function index()
{        return view('admin.settings.settings');
    }

    public function login(Request $req)
    {
        $http=new \GuzzleHttp\Client;
        try{
            $response=$http->post('http://127.0.0.1:8000/oauth/token',[
                'form_param'=>[
                    'grant_type'=>'password',
                    'client_secret'=>'MXyH1ID1Z6WYfUWZgjgCJxFTBuMxcZO66YP93uNQ',
                    'client_id'=>2,
                    'username'=>$req->username,
                    'password'=>$req->password
                ]
            ]);
        }catch(\GuzzleHttp\Exception\BadResponseException $e){
            return $e->getCode();
        }

        return $response;
    }
}
