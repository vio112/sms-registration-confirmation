<?php

Route::get('test', function(){
	echo 'Hello from the calculator package!';
});

Route::group(['middleware' => ['web']], function () {
    
    Route::get('/login', 'Vio\SmsRegistrationConfirmation\controllers\LoginController@login')->name('login');
    Route::post('/login', 'Vio\SmsRegistrationConfirmation\controllers\LoginController@postLogin');

	Route::post('/logout', 'Vio\SmsRegistrationConfirmation\controllers\LoginController@logout')->name('logout');
	
    Route::get('/register', 'Vio\SmsRegistrationConfirmation\controllers\RegistrationController@register')->name('register');
    Route::post('/register', 'Vio\SmsRegistrationConfirmation\controllers\RegistrationController@postRegister');

    Route::get('/register/confirm/{token}', 'Vio\SmsRegistrationConfirmation\controllers\RegistrationController@confirmEmail');
    
    Route::get('/register/confirm-sms', 'Vio\SmsRegistrationConfirmation\controllers\SmsController@index');
    Route::post('/register/confirm-sms', 'Vio\SmsRegistrationConfirmation\controllers\SmsController@sendSms');
    Route::post('/register/confirm-sms/validate-code', 'Vio\SmsRegistrationConfirmation\controllers\SmsController@validateSms');


});
