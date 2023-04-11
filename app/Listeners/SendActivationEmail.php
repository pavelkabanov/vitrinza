<?php

namespace App\Listeners;

use Mail;
use App\Mail\SendActivationToken;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendActivationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle($event)
    {
        if (!$event->user->active) {
            Mail::to($event->user)->send(new SendActivationToken($event->user->activationToken));
        }
    }
}
