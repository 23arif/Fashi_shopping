<?php

namespace App\Providers;

use App\Basket;
use App\Blog;
use App\Deal;
use App\PrCategory;
use App\Product;
use App\Locale;
use App\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        $maxPrice = Product::max('pr_last_price');
        $locales = Locale::all();
        $allDepartments = PrCategory::all();
        $deals = Deal::where('id', 1)->first();
        $fromTheBlog = Blog::all();
        View::share(['settings' => $settings = Settings::all(), 'locales' => $locales, 'maxPrice' => $maxPrice,
            'allDepartments' => $allDepartments,
            'deals' => $deals,
            'fromTheBlog' => $fromTheBlog,
        ]);


        view()->composer('*', function ($view) {
            $cartProducts = Basket::where('user_id',Auth::id())->get();
            $totalPrice = 0;

            foreach (Basket::where('user_id', Auth::id())->get() as $fetch) {
                $totalPrice += $fetch->getProductInfo->pr_last_price * $fetch->quantity;
            }

            $view->with(['cartProducts' => $cartProducts,'totalPrice'=>$totalPrice]);

        });
    }
}
