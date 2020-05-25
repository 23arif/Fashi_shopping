<?php

namespace App\Providers;


use App\Blog;
use App\Category;
use App\Deal;
use App\PrCategory;
use App\Product;
use App\Locale;
use App\Settings;
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
    }
}
