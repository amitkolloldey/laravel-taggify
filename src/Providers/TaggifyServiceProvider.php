<?php

namespace AmitKD\LaravelTaggify\Providers;

use Illuminate\Support\ServiceProvider;

class TaggifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Includes Package Migrations
        $this->loadMigrationsFrom(__DIR__ .'/../../migrations');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include_once(__DIR__ . '/../../helpers/helpers.php');
    }

}
