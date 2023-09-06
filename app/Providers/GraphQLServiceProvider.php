<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\GraphQL\Resolvers\ProductResolver;

class GraphQLServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->app->bind('productResolver', ProductResolver::class);
    }
}
