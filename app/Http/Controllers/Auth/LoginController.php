<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
	use AuthenticatesUsers;
	protected $redirectTo = RouteServiceProvider::HOME;
	public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function guard(){
        return Auth::guard();
    }

    public function view(){
        if (auth()->guard('user')->check()) {
            return redirect()->route('dashboard');
        }
        return view('pages.login');
    }

    public function login(Request $Request){
        if (Auth::guard('user')->attempt(['email' => $Request->email, 'password' => $Request->password ])){
            return redirect()->route('dashboard');
        }
        else{
            return redirect()->back()->with('status', 'Sorry not found your account and please check your password');
        }
    }

    public function logout(){
        auth()->guard('user')->logout();
        return redirect()->route('login');
    }
}
