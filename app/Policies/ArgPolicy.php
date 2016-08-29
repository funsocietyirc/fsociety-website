<?php

namespace Fsociety\Policies;

use Fsociety\Models\User;
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
