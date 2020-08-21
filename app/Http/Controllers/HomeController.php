<?php

namespace App\Http\Controllers;

use App\PrBrand;
use App\PrCategory;
use App\PrColor;
use App\PrSize;
use App\PrTag;
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

        $brands = PrBrand::all();
        $categories = PrCategory::all();
        $sizes = PrSize::select('size')->groupBy('size')->pluck('size');
        $colors = PrColor::all();
        $tags = PrTag::select('tag')->groupBy('tag')->pluck('tag');

        View::share([
            'brands' => $brands,
            'categories' => $categories,
            'sizes' => $sizes,
            'colors' => $colors,
            'tags' => $tags,
        ]);
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
