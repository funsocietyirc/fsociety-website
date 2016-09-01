<?php

namespace Fsociety\Providers;

use Fsociety\Models\ArgTracking;
use Fsociety\Models\User;
use Illuminate\Support\ServiceProvider;
use Silber\Bouncer\Bouncer;
use Silber\Bouncer\BouncerServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $bouncer;

    public function __construct(\Illuminate\Contracts\Foundation\Application $app)
    {
        parent::__construct($app);
        $this->bouncer = $app->make(Bouncer::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bouncer->seeder(function ()  {
            // Roles
            $siteAdmin = $this->bouncer->role()->firstOrCreate([
                'name' =>  'site-admin',
                'title' =>  'Site Administrator'
            ]);

            // Site admin can Approve ArgTracking links
            $this->bouncer->allow($siteAdmin)->to('capture',ArgTracking::class);
            $this->bouncer->allow($siteAdmin)->to('delete', ArgTracking::class);

            // If an admin exists, give privs
            $admin = User::first();
            if($admin) {
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
        if($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
