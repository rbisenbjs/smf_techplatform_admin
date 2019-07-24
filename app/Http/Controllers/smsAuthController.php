<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
#use GuzzleHttp\Client;

class smsAuthController extends Controller
{
    public function sendOTP(Request $request){
        /*
             $basic  = new \Nexmo\Client\Credentials\Basic('912e08ae', 'OG3E3e1TEle6z3aE');
             $client = new \Nexmo\Client(new \Nexmo\Client\Credentials\Container($basic));
             $ph_no=$request->phoneNumber;
             $verification = new \Nexmo\Verify\Verification($ph_no, 'test Inc');
             $REQ=$client->verify()->start($verification);
             return $verification->getRequestId();
        */
        //nexmo initialisation
        $basic  = new \Nexmo\Client\Credentials\Basic('912e08ae', 'OG3E3e1TEle6z3aE');
        $client = new \Nexmo\Client($basic);
        
        //GET the ph_no
         $ph_no=$request->phoneNumber;
        //6 digit random number
        $six_digit_random_number = mt_rand(100000, 999999);

        //send the otp
        
        $message = $client->message()->send([
            'to' => $ph_no,
            'from' => 'Nexmo',
            'text' => 'your otp is : '.$six_digit_random_number.'\n  will expire in 5 mins'
        ]);    
         
        //make the entry in the collection
        \Illuminate\Support\Facades\Config::set('database.connections.tempCon', array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => 'verfication',
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection('tempCon'); 
        $obj=DB::collection('user-verify')->where('ph_no',$ph_no)->first();
        if(sizeof($obj)!=0){ 
            DB::collection('user-verify')->where('ph_no',$ph_no)->update(['otp'=>$six_digit_random_number, 'time'=>date("Y/m/d H:i:s",time())]);
        }else
        DB::collection('user-verify')->insert(['ph_no'=>$ph_no , 'otp'=>$six_digit_random_number , 'time'=>date("Y/m/d H:i:s",time()) ]  );
       
    }
    public function verifyOTP(Request $request){
        //nexmo initialisation
        /*$basic  = new \Nexmo\Client\Credentials\Basic('912e08ae', 'OG3E3e1TEle6z3aE');
        $client = new \Nexmo\Client(new \Nexmo\Client\Credentials\Container($basic));
        //get the phone_number and otp entered by the user
        $ph_no=$request->ph_no;
        $otp=$request->code;
       //check if otp matches the collection table for that number
       \Illuminate\Support\Facades\Config::set('database.connections.tempCon', array(
        'driver'    => 'mongodb',
        'host'      => '127.0.0.1',
        'database'  => 'verfication',
        'username'  => '',
        'password'  => '',  
        ));
     DB::setDefaultConnection('tempCon'); 
     $obj=DB::collection('user-verify')->where('ph_no',$ph_no)->first();
     $otpFromServer=$obj['otp'];

     $sec=(  strtotime(date("Y/m/d H:i:s",time())) -  strtotime(date( $obj['time'] )))  ;
        
     if((integer)$otpFromServer!=(integer)$otp){
         return 'InCorrect OTP';
     }else if(($sec/60)>=5){
        DB::collection('user-verify')->where('ph_no',$ph_no)->update(['otp'=>'', 'time'=>false]);

        return 'code expired';

     }else{
		 DB::setDefaultConnection('mongodb'); 
        $user=User::where('phone',$ph_no)->first();
       //$user= DB::collection('users')->where('phone',$ph_no)->first();
        if(sizeof($user)!=0){
           //generate Oauth token using the 
           $http = new GuzzleHttp\Client;

            $response = $http->post('http://localhost:8000/oauth/token', [
            'form_params' => [
                                'grant_type' => 'password',
                                'client_id' => '5c10daab0eb9aa5d3c0043f4',
                                'client_secret' => 'QpU31yqQzl3F0sxvYaZl8dIEqD9OAGM566qXXZ2P',
                                'username' => $ph_no,
                                'password' => '123456',
                                'scope' => '*',
                    ],
            ]);

            return 'Token : '.json_decode((string) $response->getBody(), true); 
			}
        // return 'success';
     }*/


        //check if the phone exists in users table
		$ph_no=$request->ph_no;
		$user=User::where('phone',$ph_no)->first();
       //$user= DB::collection('users')->where('phone',$ph_no)->first();
	   //var_dump($user);
        if($user){
            $token = $user->createToken('Laravel Personal Access Client',['*']);
            return response()->json($token);
           //generate Oauth token using the 
           //$http = new \GuzzleHttp\Client();

            /*$response = $http->post('http://localhost:8000/oauth/token', [
            'form_params' => [
                                'grant_type' => 'password',
                                'client_id' => '5c10daab0eb9aa5d3c0043f4',
                                'client_secret' => 'QpU31yqQzl3F0sxvYaZl8dIEqD9OAGM566qXXZ2P',
                                'username' => $ph_no,
                                'password' => '123456',
                                'scope' => '*',
                    ],
            ]);
			var_dump($response->getBody());*/
			//$response = $http->get('http://localhost/bjs_mongo/public/getTestEndpoint');
			//$response = $http->get('https://jsonplaceholder.typicode.com/users');
			//return $response->getBody();

			//return json_decode((string) $response->getBody(), true);
			//var_dump($response->getBody());
			//return $response->getBody();

            //return 'Token : '.json_decode((string) $response->getBody(), true); 
		}else{
			return 'Invalid: Phone Number';
		}

    }
	
	public function getTestEndpoint(Request $request){
	   $content = array('name'=>'test');
	   return response()->json($content);
	}
}
