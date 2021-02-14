<?php

namespace App\Providers;

use App\Library\ApiOne;
use App\Library\TaskInterface;
use Illuminate\Support\ServiceProvider;

class ApiOneProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            TaskInterface::class,
            ApiOne::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
