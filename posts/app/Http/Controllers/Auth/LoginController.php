<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function signin(Request $request)
    {
         $user = DB::table('users')
                ->select('*')
                ->where('email', $request->user['email'])
                ->where('password', $request->user['password'])
                ->get();
        unset($user[0]->password);
        return $user;
    }

        public function signup(Request $request)
    {
          
        $user = DB::table('users')->where('email',  $request->user['email'])->first();

        if($user){
            return response()->json(["message"=> "User already exists "], 400);
        }else{
            $newUser = new User;
            $newUser->name = $request->user['name'];
            $newUser->email = $request->user['email'];
            $newUser->password = $request->user["password"];
            $newUser->save();
            return $newUser;
        }
        
        
    }
}