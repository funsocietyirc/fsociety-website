<?php
namespace Fsociety\Listeners;


use Fsociety\Events\ArgLinkCreatedEvent;
use Fsociety\Models\User;
use Fsociety\Services\ArgService;
use Illuminate\Events\Dispatcher;

class ArgEventSubscriber
{

    protected $class = 'Fsociety\Listeners\ArgEventSubscriber';
    protected $argService;

    public function __construct(ArgService $argService)
    {
        $this->argService = $argService;
    }

    public function onCreated($event) {
        // Update the Hash
        $this->argService->updateArgLinkHash($event->arg);
        // Send Email
        User::all()->each(function($user) use($event) {
        });
    }

    /**
     * Register the listeners for the subscriber.
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        // On Created Event
        $events->listen(ArgLinkCreatedEvent::class, $this->class . 'onCreated');
    }

}