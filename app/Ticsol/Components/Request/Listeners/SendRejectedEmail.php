<?php

namespace App\Ticsol\Components\Request\Listeners;

use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Ticsol\Components\Request\Events;
use App\Ticsol\Components\Request\Mails\RequestRejected;

class SendRejectedEmail implements ShouldQueue
{

    public $tries = 3;

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
     * @param  object  $event
     * @return void
     */
    public function handle(Events\RequestRejected $event)
    {
        Mail::to($event->req->user->email)
            ->send(new RequestRejected($event->req));
    }
}
