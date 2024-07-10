<?php

namespace App\Listeners;

use App\Events\MakeOrder;
use App\Models\Order;
use App\Notifications\MakeOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

use function App\Http\Helpers\store;

class NotificationDatabase
{
    /**
     * Create the event listener.
     */

    public $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Handle the event.
     */
    public function handle(MakeOrder $event): void
    {
        Notification::send(store()->saller, new MakeOrderNotification($event->order));
    }
}
