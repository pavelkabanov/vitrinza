<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\User;
use App\Category;
use Illuminate\Support\Facades\View;
use App\Mail\SendActivationToken;
use App\Events\UserRegistered;

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

        User::created(function ($user) {
            if (!$user->active) {
                $token = $user->activationToken()->create([
                    'token' => str_random(128),
                ]);
            }

            event(new UserRegistered($user));
        });

        //$categories = Category::all();
        $categories = Category::mainCategories();
        View::share('categories', $categories);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
