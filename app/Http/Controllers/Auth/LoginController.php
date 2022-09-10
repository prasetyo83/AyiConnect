<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    //
    // use AuthenticatesUsers;

    protected $redirectTo = '/home';
    protected $username;
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $this->username = $this->findUsername();
    }

    public function findUsername()
    {
        $login = request()->input('login');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'login'    => 'required',
            'password' => 'required',
        ]);

        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $request->merge([
            $login_type => $request->input('login')
        ]);

        if (Auth::attempt($request->only($login_type, 'password'))) {
            if (auth()->user()->isadmin == 1) {
                Session::put('access', 'Admin');
                Session::put('name', auth()->user()->name);
                return redirect()->intended($this->redirectTo);
            }else{
                Session::put('access', 'Writer');
                Session::put('name', auth()->user()->name);
                return redirect()->intended($this->redirectTo);
            }
            
            // dd("a");
        }

        return redirect()->back()
            ->withInput()
            ->withErrors([
                'login' => 'These credentials do not match our records.',
            ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        Session::forget('access') ;
        Session::forget('name') ;
        request()->session()->invalidate();
 
        request()->session()->regenerateToken();
 
        return redirect('/login');
    }


    public function view()
    {
        // $hasheds = Hash::make("a");
        return view('login');
    }
}
