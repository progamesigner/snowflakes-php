<?php

namespace ProGameSigner\Snowflakes;

use Illuminate\Support\ServiceProvider;

class SnowflakesServiceProvider extends ServiceProvider
{
    /**
     * Register snowflakes service.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('snowflakes', function ($app) {
            return new Node(
                config('services.snowflakes.id'),
                config('services.snowflakes.since', 0)
            );
        });
    }
}
