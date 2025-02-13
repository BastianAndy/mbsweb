<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Kodecabang;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    public function LoginUser(){
        $Kodecabangs = Kodecabang::all();

        return view('auth/login', ['Kodecabangs'=> $Kodecabangs]);
        // dd($request);
    }

    public function AuthLoginUser(Request $request){
        $Kodecabangs = Kodecabang::all();
        //dd(request()->kodecabang);

        return view('auth/login', ['Kodecabangs'=> $Kodecabangs]);
    }
}
