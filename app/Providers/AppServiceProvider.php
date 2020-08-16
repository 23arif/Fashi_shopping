<?php

namespace App\Providers;

use App\Basket;
use App\Blog;
use App\Deal;
use App\PrCategory;
use App\Product;
use App\Locale;
use App\Settings;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
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
        Builder::defaultStringLength(191); // Update defaultStringLength
        $maxPrice = Product::max('pr_last_price');
        $locales = Locale::all();
        $allDepartments = PrCategory::all();
        $deals = Deal::where('id', 1)->first();
        $fromTheBlog = Blog::all();
        $basketArray = Cookie::get('basket');
        $fullUrl = url()->current();
        $currentUrl = explode('/', $fullUrl);
        if (!isset($currentUrl[3])) {
            $activeUrl ='127.0.0.1:8000';
        }else{
            $activeUrl =$currentUrl[3];
        }
        View::share([
            'settings' => $settings = Settings::all(),
            'locales' => $locales,
            'maxPrice' => $maxPrice,
            'allDepartments' => $allDepartments,
            'deals' => $deals,
            'fromTheBlog' => $fromTheBlog,
            'basketArray' => $basketArray,
            'activeUrl' => $activeUrl
        ]);


        view()->composer('*', function ($view) {
            $cartProducts = Basket::where('user_id', Auth::id())->get();
            $totalPrice = 0;

            foreach (Basket::where('user_id', Auth::id())->get() as $fetch) {
                $totalPrice += $fetch->getProductInfo->pr_last_price * $fetch->quantity;
            }

            $view->with(['cartProducts' => $cartProducts, 'totalPrice' => $totalPrice]);

        });
    }
}
