<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Providers\DummyUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('dummy', function ($app, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            //dd($config);

            return new DummyUserProvider($config["model"]);
        });
    }
}
