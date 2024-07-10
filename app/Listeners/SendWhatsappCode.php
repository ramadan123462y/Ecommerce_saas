<?php

namespace App\Listeners;

use App\Events\Vertification;
use App\Services\ThirdPartyApi\Whatsapp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWhatsappCode
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Vertification $event): void
    {
        $whatsapp = new Whatsapp();
        $whatsapp->send_message($event->code);
    }
}
