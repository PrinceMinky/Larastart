<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureCommands();
        $this->configureModals();
        $this->authorizeSuperAdmin();
    }

    public function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(false);
    }


    public function configureModals(): void
    {
        Model::shouldBeStrict();

        Model::unguard();
    }

    public function authorizeSuperAdmin(): void
    {
        Gate::before(function ($user) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }
}
