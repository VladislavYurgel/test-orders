<?php

namespace App\Providers;

use App\Services\ResponseApi\Contracts\ResponseApiInterface;
use App\Services\ResponseApi\ResponseApi;
use Illuminate\Support\ServiceProvider;

class ResponseApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ResponseApiInterface::class, function ($app) {
            return new ResponseApi();
        });
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
