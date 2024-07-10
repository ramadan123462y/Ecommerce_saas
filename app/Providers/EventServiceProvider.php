<?php

namespace App\Providers;

use App\Events\MakeCart;
use App\Events\MakeOrder;
use App\Events\Vertification;
use App\Listeners\DecreasementProduct;
use App\Listeners\DeletCart;
use App\Listeners\NotificationCart;
use App\Listeners\NotificationCode;
use App\Listeners\NotificationDatabase;
use App\Listeners\SendWhatsappCode;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,

        ],
        MakeOrder::class => [
            DecreasementProduct::class,
            DeletCart::class,
            NotificationDatabase::class,

        ],
        MakeCart::class => [
            NotificationCart::class,

        ],
        Vertification::class => [
            NotificationCode::class,
            SendWhatsappCode::class,

        ],

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('dribbble', \SocialiteProviders\Dribbble\Provider::class);
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
