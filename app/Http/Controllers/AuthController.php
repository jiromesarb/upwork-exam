<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\User;
use Auth;
use Mail;
use Session;
use Validator;


class AuthController extends Controller
{

    public function login(){
        return view('auth.login');
    }

    public function postLogin(Request $request){
        // Validation
        $this->validate(request(),[
            'email' => 'required|email|max:99',
            'password'=>'required',
        ]);

        $creds = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];

        if(!$token = Auth::attempt($creds)){

            Session::flash('notif', [
                "style" => "warning",
                "message" => "Incorrect Email/Password",
            ]);
            return back();
        }

        $user = Auth::user();
        if($user->default_password == 1){
            return redirect()->route('create-password');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function createPassword(){
        return view('auth.create-password');
    }

    public function postCreatePassword(Request $request){
        // Validation
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation'=>'required|min:6',
        ]);

        User::where('id', Auth::user()->id)->update([
            'password' => bcrypt($request->password),
            'default_password' => 0,
        ]);

        return redirect()->route('dashboard');
    }

    public function forgotPassword(){
        return view('auth.passwords.forgot-password');
    }

    public function postForgotPassword(Request $request){
        // Validate Request
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Set Variables
        $token = Str::random(30); // Generate random 30 characters
        $expire_on = 30;
        $expire_reset_token = Carbon::now()->addMinutes($expire_on); // Add 30 minutes

        $user = User::where('email', $request->email)->first();

        $user['reset_token'] = $token;
        $user['expire_reset_token'] = $expire_reset_token;
        $user->update();

        $params = [
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token,
            'expire_reset_token' => $expire_reset_token,
        ];
        $params['type'] = 'forgot-password';

        $to = $request->email;
        Mail::send('email.user-email', $params, function ($m) use($request, $to) {
            $m->subject('Reset Password');
            $m->to($to);
        });

        Session::flash('notif', [
            "style" => "success",
            "message" => "We send you an email to reset your password.",
        ]);

        return redirect()->route('login');
    }

    public function resetPassword($token){
        $user = User::where('reset_token', $token)->first();

        if(empty($user)){

            Session::flash('notif', [
                "style" => "danger",
                "message" => "Invalid reset token. Please try again.",
            ]);
            return redirect()->route('login');
        }

        // Check expire reset token time
        if(Carbon::parse($user->expire_reset_token) < Carbon::now()){

            Session::flash('notif', [
                "style" => "danger",
                "message" => "The token was already expired. Please reset password again.",
            ]);
            return redirect()->route('login');
        }
        return view('auth.passwords.reset-password', compact('token'));
    }

    public function postResetPassword($token, Request $request){
        $user = User::where('reset_token', $token)->first();

        // Check if token is valid
        if(empty($user)){
            Session::flash('notif', [
                "style" => "danger",
                "message" => "Invalid reset token. Please try again.",
            ]);
            return redirect()->route('login');
        }

        // Check expire reset token time
        if(Carbon::parse($user->expire_reset_token) < Carbon::now()){
            Session::flash('notif', [
                "style" => "danger",
                "message" => "The token was already expired. Please try again.",
            ]);
            return redirect()->route('login');
        }

        // Validation
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation'=>'required|min:6',
        ]);

        // Update User
        $user->update([
            'password' =>  bcrypt($request->password_confirmation),
            'default_password' => 0,
            'reset_token' => null,
            'expire_reset_token' => null,
        ]);

        Session::flash('notif', [
            "style" => "success",
            "message" => "You successfully reset your password.",
        ]);

        return redirect()->route('login');
    }


}
