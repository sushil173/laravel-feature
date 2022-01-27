<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }  
      

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')->withSuccess('Signed in');
        }
        return redirect("login")->withSuccess('Login details are not valid');
    }



    public function registration()
    {
        if(Auth::check()){
            // return view('dashboard');
            return view('auth.invite');
        } else {
            return redirect()->back()->with('info', 'You are not allowed');
        }
    }
      

    public function customRegistration(Request $request)
    {  
        $request->validate([
            'email' => 'required|email|unique:users',
        ]);
           
        $data = array_merge($request->all(), ['otp' => rand(0, 999999), 'url'=> URL::to('/')]);
        $check = $this->create($data);
        $data = array_merge($data, ['id' => $check->id, 'type' => 'admin']);
        // dd($check->id);
        // e-mail send
        Mail::send('mail', $data, function($message) use ($check) {
            $message->to($check->email)->subject('Invite to join');
        });
        return redirect("dashboard")->withSuccess('Invited Successfully. Please check email');
    }
    
    // for user
    public function userRegistration(Request $request)
    {  
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);
           
        // $data = array_merge($request->all(), ['otp' => rand(0, 999999), 'url'=> URL::to('/')]);
        $data = $request->all();
        $afterOtp = rand(0, 999999);
        $check = $this->update($data, $afterOtp);
        $userdata = array_merge(['type' => 'user', 'after_otp' => $afterOtp]);
        // dd($check->id);
        $auth = Auth::user();
        // e-mail send
        Mail::send('mail', $userdata, function($message) use ($auth) {
            $message->to($auth->email)->subject('OTP for Complete');
        });
        return redirect("userotp")->withSuccess('OTP send on email Successfully.');
    }


    public function create(array $data)
    {
      return User::create([
        'email' => $data['email'],
        'otp' => $data['otp'],
        'status' => '2', // invited
      ]);
    }    
    
    public function update(array $data, $afterOtp)
    {
        return User::find(Auth::user()->id)->update([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'status' => '3', // PIN send
            'after_otp' => $afterOtp
        ]);
    }    
    

    public function dashboard()
    {
        if(Auth::check()){
            if(Auth::user()->is_admin)
                return view('admindashboard');
            else{
                //user
                if(Auth::user()->status == 2) //invited
                    return view('dashboard');
                elseif(Auth::user()->status == 3 ) //PIN
                    return view('user.dashboard');
                else
                    return view('dashboard');
            }
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function userOtp(Request $request)
    {
        if(Auth::check()){
            if(Auth::user()->status == 3)
                return view('user.dashboard');
            else 
            return redirect('dashboard')->withInfo('You are not allowed to access');
        }
  
        return redirect()->back()->withSuccess('You are not allowed to access');
    }
    
    public function postUserOtp(Request $request)
    {
        $request->validate([
            'after_otp' => 'required',
        ]);

        if(Auth::check()){
            if(Auth::user()->after_otp == $request->after_otp ){
                User::find(Auth::user()->id)->update([
                    'status' => '1', // success
                    'after_otp' => null
                ]);
                return redirect("dashboard")->withSuccess('Success');
            }
            else
                return redirect()->back()->with('info', 'OTP is not verified');
        }
        return redirect("login")->withSuccess('You are not allowed to access');

    }
    

    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }

    public function verifyUrl(Request $request, $email, $otp, $id) {
        //check user
        $user = User::select('*')->where('id',$id)->where('email',$email)->Where('otp',$otp)->first();
        if(!empty($user)){
            Auth::loginUsingId($id,$remember = true);
            return redirect()->intended('dashboard')->withSuccess('Link Verified');
        }
        else
            return Redirect('login')->with('info', 'Link is not verified');
    }
}