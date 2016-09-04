<?php

namespace Fsociety\Listeners;

use Fsociety\Events\ArgLinkCreatedEvent;
use Fsociety\Services\ArgService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArgLinkCreatedListener implements ShouldQueue
{
    protected $argService;
    public function __construct(ArgService $argService)
    {
        $this->argService = $argService;
    }

    /**
     * Handle the event.
     *
     * @param  ArgLinkCreatedEvent  $event
     * @return void
     */
    public function handle(ArgLinkCreatedEvent $event)
    {
        $this->argService->updateArgLinkHash($event->arg);

    }
}
