<?php

namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Stevebauman\Location\Facades\Location;

  
class AuthController extends Controller
{
    var $currentUserInfo;
    var $langLocale ="en";
    var $country;
    
    public function __construct() {
        //$ip = "103.10.67.255"; //id
        //$ip ="103.82.128.67"; //uk
        $ip = "109.227.191.100"; //spain
        //App::setLocale('es');
        //App::setLocale('es');
        //$ip = request()->ip(); 
        //dd($clientIP);
        
        $this->currentUserInfo = Location::get($ip);
        $this->langLocale = $this->currentUserInfo->countryCode;
        $this->country = $this->currentUserInfo->countryName;
        
        \Illuminate\Support\Facades\App::setLocale(strtolower($this->langLocale));
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {        
        $country =  $this->country;
        return view('auth.login', compact('country'));
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            
            //$request->session()->regenerate();
            $user = User::where('email',$request->email)->get();
            $subdomainUrl = "";
            foreach($user as $val){             
              $request->session()->put('email', $val->email);
              $subdomainUrl = $val->subdomain;
              $request->session()->put('subdomain', $subdomainUrl);
              $request->session()->put('password', $val->password);  
              $request->session()->put('name', $val->name);  
            }            
            
           
            //return redirect()->away($subdomainUrl);
            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }
  
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {          
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'subdomain' => 'required|url',
        ]);
                
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
            //$data = request()->session()->all();
            //dd($data);
            return view('dashboard');
        }
        
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'subdomain' => $data['subdomain'],  
        'password' => Hash::make($data['password'])
      ]);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();
        
        request()->session()->invalidate();
 
        request()->session()->regenerateToken();
  
        return Redirect('login');
    }
}