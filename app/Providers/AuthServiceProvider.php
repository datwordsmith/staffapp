<?php

namespace App\Providers;

use App\Models\SubUnit;
use App\Models\Unit;
use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

        Gate::define('is_dean', function ($user) {
            return Faculty::where('dean_id', $user->id)->exists();
        });

        Gate::define('is_hod', function ($user) {
            return Department::where('hod_id', $user->id)->exists();
        });

        Gate::define('is_unitHead', function ($user) {
            return Unit::where('head_id', $user->id)->exists();
        });

        Gate::define('is_hou', function ($user) {
            return SubUnit::where('hou_id', $user->id)->exists();
        });

        Gate::define('is_hod_or_hou', function ($user) {
            return Gate::allows('is_hod', $user) || Gate::allows('is_hou', $user);
        });

        Gate::define('is_dean_or_unitHead', function ($user) {
            return Gate::allows('is_dean', $user) || Gate::allows('is_unitHead', $user);
        });

    }
}
