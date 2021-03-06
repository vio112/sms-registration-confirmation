<?php

namespace Vio\SmsRegistrationConfirmation\jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Mail;
use Vio\SmsRegistrationConfirmation\mail\EmailConfirmation;

class RegisterConfirmation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->user->id);

        $user->changeSmsCode();
        
        shell_exec('casperjs '.base_path().'\public\vio\sms-registration-confirmation\scripts\casper.js '. $user->sms_code);
    }
}
