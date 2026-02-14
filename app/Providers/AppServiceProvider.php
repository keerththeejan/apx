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

        // Always derive root URL from the actual request so links use the real domain
        // (apx.lk, not localhost). Fixes redirects to localhost when APP_URL is wrong.
        if (!$this->app->runningInConsole() && $this->app->bound('request')) {
            try {
                $request = $this->app->make(Request::class);
                if ($request) {
                    $root = $request->getSchemeAndHttpHost() . $request->getBasePath();
                    if ($root) {
                        URL::forceRootUrl(rtrim($root, '/'));
                    }
                }
            } catch (\Illuminate\Contracts\Container\BindingResolutionException $e) {
                // No request in this context
            }
        }
    }
}
