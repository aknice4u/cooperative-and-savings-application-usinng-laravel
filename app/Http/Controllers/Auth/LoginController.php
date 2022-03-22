<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
//use App\Rules\Captcha;
use DB;
use Auth;

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
    
    public function username()
    {
        return 'username';
    } 

    protected $redirectTo = '/home';
    protected $username = 'username';
    
    
    public function login(Request $request)
    {  
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            //'g-recaptcha-response' => 'required|string',
            //'g-recaptcha-response' => new Captcha(),
        ]);
        
        if (Auth::attempt(['username' => $request['username'], 'password' => $request['password'] ]) || Auth::attempt(['email' => $request['email'], 'password' => $request['password'] ]) ) {

            return redirect()->intended($this->redirectPath());
        } else {
            return redirect('/')->with('error','Username or password not correct');
        }
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
