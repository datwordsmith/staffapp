<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('superadmin', function ($user) {
            return $user->role_as == 0;
        });

        Gate::define('admin', function ($user) {
            return $user->role_as == 1;
        });

        Gate::define('staff', function ($user) {
            return $user->role_as == 2;
        });

        Gate::define('non_academic_staff', function ($user) {
            return $user->role_as == 3;
        });
    }
}
