<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Organisation;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|digits:10',
            'dob' => 'required|string',
            'gender' => 'required|string',
            'org_id'=>'required|integer',
            'role_id'=>'required|integer'
        ]);
    }


    public function showRegistrationForm()
    {    
        $orgs=Organisation::where('orgshow','<>',0)->get();
      
        return view('auth.register',compact('orgs'));
    }

    public function register(Request $request)
    {   
      
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        $this->guard()->login($user);

        $user=DB::select('select * from users where email = ?', [$request->email]);
      
        //make an entry in the roles users table
        DB::insert('insert into role_user (user_id,role_id) values(?,?)',[$user[0]->id,$request->role_id]);

       
        return $this->registered($request, $user)
                        ?:redirect($this->redirectPath());

      
       
    }

    protected function registered(Request $request, $user)
    {
        //
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'dob' => $data['dob'],
            'gender' => $data['gender'],
            'org_id'=>$data['org_id'],
            'role_id'=>$data['role_id']
        ]);
    }
}
