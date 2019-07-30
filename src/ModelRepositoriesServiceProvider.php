<?php
namespace bedoke\ModelRepositories;
use Illuminate\Support\ServiceProvider;

class ModelRepositoriesServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
       /*  $this->publishes([
            __DIR__.'/config/model_repositories.php' => config_path('model_repositories.php'),
        ]); */
    }

    public function register()
    {
        $this->app->bind('ModelRepositories', 'bedoke\ModelRepositories\ModelRepositories');
        /* $this->mergeConfigFrom(
            __DIR__.'/config/model_repositories.php', 'model_repositories'
        ); */
    }

}
