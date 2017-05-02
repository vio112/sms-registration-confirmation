<?php

namespace Vio\SmsRegistrationConfirmation\controllers;

use App\User;
use App\Http\Controllers\Controller as BaseController;
use Vio\SmsRegistrationConfirmation\jobs\RegisterConfirmation;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Vio\SmsRegistrationConfirmation\mail\EmailConfirmation;

class RegistrationController extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register()
    {
    	return view('package::register');
    }

    public function postRegister(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|max:255',
    		'email' => 'required|email|max:255|unique:users',
    		'password' => 'required|min:6|confirmed',
            'contact_number' => 'required|size:15',
    	]);
        
    	$user = User::create($request->all());
        
        session(['user_id' => $user->id]);

        if ($request->radioGroup == 'email') 
        {
            $user->token = str_random(20);
            $user->save();
            Mail::to($request->email)->send(new EmailConfirmation($user));
            return redirect('/login');
        }
        else
        {
            dispatch(new RegisterConfirmation($user));
            return redirect('/register/confirm-sms');
        }	
    }

    public function confirmEmail($token){
    	
        $user = User::whereToken($token)->firstOrFail()->confirmEmail();

        session()->flash('message', 'You are now confirmed! Please Login.');

        return redirect('/login');

    }
}
