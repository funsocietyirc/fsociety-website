<?php

namespace Fsociety\Providers;

use Fsociety\Models\ArgTracking;
use Fsociety\Policies\ArgPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Fsociety\Model' => 'Fsociety\Policies\ModelPolicy',
        ArgTracking::class => ArgPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
