<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // When app runs in a subfolder (e.g. /apx), ensure route() and url() use that base
        // so admin and public links work without relying on APP_URL being set correctly.
        if (!$this->app->runningInConsole() && $this->app->bound('request')) {
            try {
                $request = $this->app->make(Request::class);
                if ($request && $request->getBasePath()) {
                    URL::forceRootUrl($request->getSchemeAndHttpHost() . $request->getBasePath());
                }
            } catch (\Illuminate\Contracts\Container\BindingResolutionException $e) {
                // No request in this context
            }
        }
    }
}
