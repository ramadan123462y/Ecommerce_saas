<?php

namespace App\Listeners;

use App\Events\MakeCart;
use App\Notifications\CreateCart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

use function App\Http\Helpers\store;

class NotificationCart
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
    public function handle(MakeCart $event): void
    {
        Notification::send(store()->saller, new CreateCart($event->cart));
    }
}
