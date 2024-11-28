<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->app->bind('path.public', function() {
            return base_path().'/public_html';
        });

        // Other boot logic...

        View::composer('admin.order_items.create', function ($view) {
            $view->with('users', User::query()->select('id', 'firstName', 'lastName')->get());
        });
    }
}
