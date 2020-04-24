<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use App\FAQs;
use App\Settings;
use App\User;

class AdminGetController extends AdminController
{
    public function get_index()
    {
        return view('backend.index');
    }

    public function get_settings()
    {
        return view('backend.settings');
    }

    public function get_blog()
    {
        $categories = Category::where('up_category', '0')->get();
        $blogs = Blog::all();
        return view('backend.blog')->with('blogs', $blogs)->with('categories', $categories);
    }

    public function get_edit_blog($slug)
    {
        $categories = Category::where('up_category', '0')->get();
        $blog = Blog::where('slug', $slug)->first();
        return view('backend.edit-blog')->with('blog', $blog)->with('categories', $categories);
    }

    public function get_category()
    {
        $categories = Category::where('up_category', '0')->get();
        return view('backend.category')->with('categories', $categories);

    }

    public function get_faq()
    {
        $faqs = FAQs::all();
        return view('backend.faq')->with('faqs',$faqs);
    }
    public function get_edit_faq($slug){
        $topic = FAQs::where('slug',$slug)->first();
        return view('backend.edit-faq')->with('topic',$topic);
    }

    public function get_profile_user($username){
        $id = explode('-',$username);
        $datas = User::where('id',$id[count($id) - 1])->get();
        return view('backend.profile')->with('datas',$datas);
    }
}
