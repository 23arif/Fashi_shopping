<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Blog;
use App\BlogTags;
use App\Deal;
use App\Locale;
use App\PrBrand;
use App\PrCategory;
use App\PrColor;
use App\Product;
use App\PrSize;
use App\PrTag;
use App\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth'); -- Code for go to login page before everthing
        $settings = Settings::all();
        $brands = PrBrand::all();
        $categories = PrCategory::all();
        $sizes = PrSize::select('size')->groupBy('size')->pluck('size');
        $colors = PrColor::select('color_code')->groupBy('color_code')->pluck('color_code');
        $tags = PrTag::select('tag')->groupBy('tag')->orderByRaw('CHAR_LENGTH(tag)')->pluck('tag');
        $blogTags = BlogTags::select('tag')->groupBy('tag')->orderByRaw('CHAR_LENGTH(tag)')->pluck('tag');
        $maxPrice = (Product::max('pr_last_price')) + 1;
        $locales = Locale::all();
        $allDepartments = PrCategory::all();
        $deals = Deal::where('id', 1)->first();
        $fromTheBlog = Blog::all();
        $basketArray = Cookie::get('basket');

        $fullUrl = url()->current();
        $currentUrl = explode('/', $fullUrl);
        if (!isset($currentUrl[3])) {
            $activeUrl = '127.0.0.1:8000';
        } else {
            $activeUrl = $currentUrl[3];
        }

        View::share([
            'settings' => $settings,
            'locales' => $locales,
            'maxPrice' => $maxPrice,
            'allDepartments' => $allDepartments,
            'deals' => $deals,
            'fromTheBlog' => $fromTheBlog,
            'basketArray' => $basketArray,
            'activeUrl' => $activeUrl,
            'brands' => $brands,
            'categories' => $categories,
            'sizes' => $sizes,
            'colors' => $colors,
            'tags' => $tags,
            'blogTags' => $blogTags,
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontend.index');
    }
}
