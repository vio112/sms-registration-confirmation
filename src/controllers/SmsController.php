<?php

namespace Vio\SmsRegistrationConfirmation\controllers;

use App\User;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;


class SmsController extends BaseController
{
    public function index()
    {
        if(!session()->has('user_id'))
        {
            return redirect('/login');
        }

        return view('sms-registration-confirmation::confirm');
    }

    public function sendSms(Request $request)
    {
        $user = User::find(session('user_id'));

        $user->changeToken();

        shell_exec('casperjs '.base_path().'\packages\vio\sms-registration-confirmation\src\scripts\casper.js '. $user->token);
    }

    public function validateSms(Request $request)
    {
        $user = User::whereSms_code($request->code)->first();

        if($user)
        {
            $user->confirmSms();

            session()->forget('conf-auth');

            session()->flash('message', 'You are now confirmed! Please Login.');
        }
        else
        {
            session()->flash('message', 'Incorrect code..');
            return back();
        }   

        return redirect('/login');
    }
}
