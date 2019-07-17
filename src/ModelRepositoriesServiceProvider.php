<?php
namespace bedoke\ModelRepositories;
use Illuminate\Support\ServiceProvider;

class ModelRepositoriesServiceProvider extends ServiceProvider {

    public function boot()
    {
        # $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        # $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        # $this->loadViewsFrom(__DIR__.'/views', 'ModelRepositories');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        /* $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/ModelRepositories')
        ]); */
        /* $this->publishes([
            __DIR__.'/config/role_perms.php' => config_path('role_perms.php'),
        ]); */
    }

    public function register()
    {
        /* $this->app->bind('ModelRepositories', 'bedoke\ModelRepositories\ModelRepositories');
        $this->mergeConfigFrom(
            __DIR__.'/config/model_repositories.php', 'model_repositories'
        ); */
    }

}
