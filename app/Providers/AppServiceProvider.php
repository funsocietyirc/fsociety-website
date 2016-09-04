<?php

namespace Fsociety\Providers;

use Bouncer;
use Fsociety\Models\ArgTracking;
use Fsociety\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Bouncer::seeder(
            function () {
                // Roles
                $siteAdmin = Bouncer::role()->firstOrCreate([
                    'name' => 'site-admin',
                    'title' => 'Site Administrator'
                ]);
                // Site admin can Approve ArgTracking links
                Bouncer::allow($siteAdmin)->to('capture', ArgTracking::class);
                Bouncer::allow($siteAdmin)->to('delete', ArgTracking::class);
                Bouncer::allow($siteAdmin)->to('modify-watch', ArgTracking::class);

                // If an admin exists, give privileges
                $admin = User::first();
                if ($admin) {
                    User::first()->assign($siteAdmin);
                }
            });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
