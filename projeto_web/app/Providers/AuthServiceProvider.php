<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Model\seguranca\Permission;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        $permission = Permission::with('roles')->get();

        foreach ($permission as $permissao) {
            $gate->define($permissao->per_name, function(User $user) use ($permissao) {
                return $user->hasPermission($permissao);
            });
        }
        
        //Acesso Total para o Administrativo
        $gate->before(function(User $user, $ability) {
            if($user->hasAnyRoles('adm'))
                return true;
        });
    }
}
