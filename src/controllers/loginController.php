<?php

namespace Vio\SmsRegistrationConfirmation\controllers;

use App\User;
use App\Http\Controllers\Controller as BaseController;
use Vio\SmsRegistrationConfirmation\jobs\RegisterConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class loginController extends BaseController
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login()
    {
    	return view('sms-registration-confirmation::login');
    }

    public function postLogin(Request $request)
    {
    	$this->validate($request, ['email' => 'required|email', 'password' => 'required']);

    	if(Auth::attempt($this->credentials($request)))
    	{
    		return redirect()->intended('/home');
    	}
        elseif (Auth::attempt($this->credentialsForNotAuth($request)))
        { 
            // auth_user = user data garthered from the authenticated user session.
            $auth_user = auth()->user();

            session()->flush();

            if($auth_user->token)
            {
                session()->flash('message', 'Please confirm your email...');

                return redirect('/login');
            }

            session(['user_id' => $auth_user->id]);

            session()->flash('message', 'Verification Code already sent to: '. $auth_user->contact_number);

            dispatch(new RegisterConfirmation($auth_user));

            return redirect('/register/confirm-sms');
        }	

        session()->flash('message', 'Could not sign you in');

    	return redirect()->back();
    }

    public function logout()
    {
    	Auth::logout();
    	return view('sms-registration-confirmation::login');
    }

    protected function credentials(Request $request)
    {
        return [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'is_activated' => true
        ];
    }

    protected function credentialsForNotAuth(Request $request)
    {
        return [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'is_activated' => false
        ];
    }
}
