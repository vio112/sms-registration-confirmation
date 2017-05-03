<?php

namespace Vio\SmsRegistrationConfirmation;

use Illuminate\Support\ServiceProvider;

class SmsRegistrationConfirmationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        $this->loadMigrationsFrom(__DIR__.'/migrations');

        $this->loadViewsFrom(__DIR__.'/views/auth', 'sms-registration-confirmation');

        $this->publishes([__DIR__.'/views/auth' => resource_path('views/vendor/sms-registration-confirmation/views')], 'vio-views');

        $this->publishes([__DIR__.'/views/mail' => resource_path('views/vendor/sms-registration-confirmation/mail')], 'vio-mail');

        $this->publishes([__DIR__.'/assets' => public_path('vio/sms-registration-confirmation/assets')], 'vio-formHelper');

        $this->publishes([__DIR__.'/scripts' => public_path('vio/sms-registration-confirmation/scripts')], 'vio-scraper');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Vio\SmsRegistrationConfirmation\controllers\loginController');
        $this->app->make('Vio\SmsRegistrationConfirmation\controllers\RegistrationController');
        $this->app->make('Vio\SmsRegistrationConfirmation\controllers\SmsController');
    }
}
