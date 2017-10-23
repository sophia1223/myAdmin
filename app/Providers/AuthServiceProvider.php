<?php

namespace App\Providers;

use App\Models\Permission;
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
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        if (!empty($_SERVER['SCRIPT_NAME']) && strtolower($_SERVER['SCRIPT_NAME']) === 'artisan') {
            return false;
        }

        $this->registerPolicies();

        //
        Gate::before(function ($user) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });

        $permissions= Permission::with('roles')->get();
        foreach ($permissions as $permission) {
            Gate::define($permission->alias, function($user) use ($permission) {
                return $user->hasPermission($permission);
            });  //执行用户授权
        }
    }
}
