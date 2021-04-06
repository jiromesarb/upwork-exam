<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public static $permissions = [
        // Position Management
        'index-positions' => ['admin', 'manager', 'user'],
        'create-positions' => ['admin', 'manager'],
        'store-positions' => ['admin', 'manager'],
        'edit-positions' => ['admin', 'manager'],
        'update-positions' => ['admin', 'manager'],
        'destroy-positions' => ['admin'],

        // Department Management
        'index-departments' => ['admin', 'manager', 'user'],
        'create-departments' => ['admin', 'manager'],
        'store-departments' => ['admin', 'manager'],
        'edit-departments' => ['admin', 'manager'],
        'update-departments' => ['admin', 'manager'],
        'destroy-departments' => ['admin'],

        // User Management
        'index-users' => ['admin', 'manager', 'user'],
        'create-users' => ['admin', 'manager'],
        'store-users' => ['admin', 'manager'],
        'edit-users' => ['admin', 'manager'],
        'update-users' => ['admin', 'manager'],
        'destroy-users' => ['admin'],

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(
            function ($user, $ability) {
                if ($user->role === 'admin') {
                    return true;
                }
            }
        );

        foreach (self::$permissions as $action=> $roles) {
            Gate::define(
                $action,
                function (User $user) use ($roles) {
                    if (in_array($user->role, $roles)) {
                        return true;
                    }
                }
            );
        }
    }
}
