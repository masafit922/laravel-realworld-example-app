<?php

namespace App\Providers;

use App\Http\Parsers\TokenAuthHeader;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Http\Parser\Parser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Accept "Authorization: Token <jwt>" (RealWorld spec) as well as the default "Bearer".
        $this->app->extend('tymon.jwt.parser', function (Parser $parser) {
            return $parser->setChain(array_merge([new TokenAuthHeader], $parser->getChain()));
        });
    }
}
