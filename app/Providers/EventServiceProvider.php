<?php

namespace Fsociety\Providers;

use Fsociety\Events\ArgLinkCreatedEvent;
use Fsociety\Listeners\ArgEventSubscriber;
use Fsociety\Listeners\ArgLinkCreatedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
    ];

    protected $subscribe = [
        ArgEventSubscriber::class
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
