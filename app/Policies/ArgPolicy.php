<?php

namespace Fsociety\Policies;

use Fsociety\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArgPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // A poster owns this link
    public function update() {
    }
}
