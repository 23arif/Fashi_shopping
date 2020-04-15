<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use App\Settings;

class AdminGetController extends AdminController
{
    public function get_index()
    {
        return view('backend.index');
    }

    public function get_settings()
    {
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('backend.settings')->with('settings', $settings);
    }

    public function get_blog()
    {
        $categories = Category::where('up_category','0')->get();
        $blogs = Blog::all();
        return view('backend.blog')->with('blogs', $blogs)->with('categories',$categories);
    }

    public function get_edit_blog($slug)
    {
        $categories = Category::where('up_category','0')->get();
        $blog = Blog::where('slug', $slug)->first();
        return view('backend.edit-blog')->with('blog',$blog)->with('categories',$categories);
    }

    public function get_category()
    {
        $categories = Category::where('up_category','0')->get();
        return view('backend.category')->with('categories',$categories);

    }
}
