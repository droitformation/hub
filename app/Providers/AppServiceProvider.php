<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');

        $socialite->extend(
            'droithub',
            function ($app) use ($socialite) {
                $config = $app['config']['services.droithub'];
                return $socialite->buildProvider(\App\Services\DroitHubProvider::class, $config);
            }
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerUserService();
    }

    /**
     * User
     */
    protected function registerUserService(){

        $this->app->singleton('App\Hub\User\Repo\UserInterface', function()
        {
            return new \App\Hub\User\Repo\UserEloquent(new \App\Hub\User\Entities\User);
        });
    }
}
