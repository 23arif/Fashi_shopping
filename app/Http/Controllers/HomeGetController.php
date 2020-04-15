<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use App\Settings;

class HomeGetController extends HomeController
{
    public function get_index()
    {
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('frontend.index')->with('settings', $settings);
    }

    public function get_index_yonlendir()
    {
        return redirect('/');
    }

    public function get_contact()
    {
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('frontend.contact')->with('settings', $settings);
    }

    public function get_blog()
    {
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        $blogs = Blog::orderBy('id', 'desc')->get();
        $categories = Category::where('up_category', '0')->get();
        return view('frontend.blog')->with('settings', $settings)->with('blogs', $blogs)->with('categories', $categories);
    }

    public function get_blog_content($slug)
    {
        $category = explode('/', $slug); //Explodes category slugs
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        $blogs = Blog::where('slug', $category[count($category) - 1])->first();
        if(isset($blogs)){
            return view('frontend.blog-details')->with('settings', $settings)->with('blogs', $blogs)->with('blogCategory', $category);
        }else{
            $getLastCat = $category[count($category) - 1];
            $getCat = Category::where('slug',$getLastCat)->get();
            $blogs = $getCat[0]->classifiedBlogs;
            return view('frontend.blog')->with('settings', $settings)->with('blogs', $blogs)->with('categories', $getCat);

        }

    }

    public function get_checkout()
    {
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('frontend.check-out')->with('settings', $settings);
    }

    public function get_login()
    {
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('frontend.login')->with('settings', $settings);;
    }

    public function get_product()
    {
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('frontend.product')->with('settings', $settings);;
    }

    public function get_register()
    {
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('frontend.register')->with('settings', $settings);;
    }

    public function get_shop()
    {
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('frontend.shop')->with('settings', $settings);;
    }

    public function get_shopping_cart()
    {
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('frontend.shopping-cart')->with('settings', $settings);;
    }
}
