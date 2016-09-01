<?php

namespace Fsociety\Policies;

use Fsociety\Models\ArgTracking;
use Fsociety\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use PhpParser\Node\Arg;

class ArgTrackingPolicy
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

    public function before(User $user, $ability) {
        if($user->isAn('site-admin') || $user->isAn('admin')) {
            return true;
        }
    }

    public function delete(User $user, ArgTracking $arg) {
        return $user->owns($arg);
    }

    public function edit(User $user, ArgTracking $arg) {
        return $user->owns($arg);
    }
}
