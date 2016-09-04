<?php
namespace Fsociety\Listeners;


use Fsociety\Events\ArgLinkCreatedEvent;
use Fsociety\Events\ArgLinkHashUpdateEvent;
use Fsociety\Mail\ArgLinkUpdatedMail;
use Fsociety\Models\User;
use Fsociety\Services\ArgService;
use Illuminate\Events\Dispatcher;
use Mail;

class ArgEventSubscriber
{

    protected $class = 'Fsociety\Listeners\ArgEventSubscriber@';
    protected $argService;

    public function __construct(ArgService $argService)
    {
        $this->argService = $argService;
    }


    /**
     * Fired when an ARG Link is created
     * @param $event
     */
    public function onCreated($event) {
        // Update the Hash
        $this->argService->updateArgLinkHash($event->arg);
        // Send Email
        User::all()->each(function($user) use($event) {
            try {
                Mail::to($user->email)->send(
                    new ArgLinkUpdatedMail(
                        $event->arg,
                        "{$event->arg->name} has been created.",
                        "The Alternate Reality Game link has been created by {$event->user->name}."
                    ));
            } catch(\Swift_TransportException $ex) {
                return;
            }
        });
    }

    /**
     * Fired when the Hash changes on a ARG link
     * @param $event
     */
    public function onHashUpdated($event) {
        User::all()->each(function ($user) use ($event) {
            try {
                Mail::to($user->email)->send(
                    new ArgLinkUpdatedMail(
                        $event->arg,
                        "{$event->arg->name} has had its content updated.",
                        "The Alternate Reality Game link has been modified since its last indexing."
                    ));
            } catch(\Swift_TransportException $ex) {
                return;
            }
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
        $events->listen(ArgLinkHashUpdateEvent::class, $this->class . 'onHashUpdated');
    }

}