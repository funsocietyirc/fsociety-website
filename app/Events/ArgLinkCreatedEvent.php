<?php

namespace Fsociety\Events;

use Fsociety\Models\ArgTracking;
use Illuminate\Queue\SerializesModels;

class ArgLinkCreatedEvent
{
    use SerializesModels;
    public $arg;

    public function __construct(ArgTracking $arg)
    {
        $this->arg = $arg;
    }
}
