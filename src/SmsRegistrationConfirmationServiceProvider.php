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

        $this->loadViewsFrom(__DIR__.'/views', 'sms-registration-confirmation');

        $this->publishes([__DIR__.'/views' => resource_path('views/vendor/sms-registration-confirmation')], 'vio-views');

        $this->publishes([__DIR__.'/assets' => public_path('vio/sms-registration-confirmation/assets')], 'vio-assets');
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
