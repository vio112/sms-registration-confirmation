<?php

namespace Vio\SmsRegistrationConfirmation\traits;

trait UserHelper
{
	public function setPasswordAttribute($password)
	{
	    $this->attributes['password'] = bcrypt($password);
	}
	
	public function getContactNumberAttribute($c_number)
	{
	    return str_replace("-", "",$c_number);
	}
	
	public function confirmEmail()
	{
	    $this->is_activated = true;
	    $this->token = null;
	    $this->save();
	}

	public function confirmSms()
	{
	    $this->is_activated = true;
	    $this->token = null;
	    $this->save();
	}

	public function changeSmsCode()
	{
	    $this->sms_code = str_random(5);
	    $this->save();
	}
}
