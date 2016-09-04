<?php
namespace Fsociety\Events;
use Fsociety\Models\ArgTracking;
use Fsociety\Models\User;
use Illuminate\Queue\SerializesModels;

class ArgLinkBaseEvent
{
    use SerializesModels;
    public $arg;
    public $user;

    public function __construct(ArgTracking $arg, User $user)
    {
        $this->arg = $arg;
        $this->user = $user;
    }
}