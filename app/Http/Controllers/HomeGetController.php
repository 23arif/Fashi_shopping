<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use App\FAQs;
use App\FaqTopic;
use App\Settings;
use App\User;

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

    public function get_blog_author($authorName)
    {
        $y = explode('-', $authorName);
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        $blogs = Blog::where('author', $y[count($y) - 1])->orderBy('id', 'desc')->get();
        $categories = Category::where('up_category', '0')->get();
        return view('frontend.blog')->with('settings', $settings)->with('blogs', $blogs)->with('categories', $categories);
    }

    public function get_blog_tags($tagName)
    {
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        $blogs = Blog::where('tags', 'LIKE', '%' . $tagName . '%')->orderBy('id', 'desc')->get();
        $categories = Category::where('up_category', '0')->get();
        return view('frontend.blog')->with('settings', $settings)->with('blogs', $blogs)->with('categories', $categories);
    }

    public function get_blog_content($slug)
    {
        $category = explode('/', $slug); //Explodes category slugs
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        $blogs = Blog::where('slug', $category[count($category) - 1])->first();
        if (isset($blogs)) {
            return view('frontend.blog-details')->with('settings', $settings)->with('blogs', $blogs)->with('blogCategory', $category);
        } else {
            $getLastCat = $category[count($category) - 1];
            $getCat = Category::where('slug', $getLastCat)->get();
            $blogs = $getCat[0]->classifiedBlogs;
            return view('frontend.blog')->with('settings', $settings)->with('blogs', $blogs)->with('categories', $getCat);

        }

    }

    public function get_checkout()
    {
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('frontend.check-out')->with('settings', $settings);
    }

    public function get_product()
    {
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('frontend.product')->with('settings', $settings);;
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

    public function get_faq()
    {
        $faqTopics = FaqTopic::orderBy('id', 'desc')->get();
        $prime_titles = FAQs::all();
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('frontend.faq')->with('settings', $settings)->with('prime_titles', $prime_titles)->with('faqTopics', $faqTopics);
    }

    public function get_add_faq()
    {
        $topics = FAQs::all();
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('frontend.add-faq')->with('settings', $settings)->with('topics', $topics);

    }

    public function get_faq_author($slug)
    {
        $s = explode('-', $slug);
        $author = User::where('id', $s[count($s) - 1])->first();
        $questions = FaqTopic::where('author', $s[count($s) - 1])->orderBy('id', 'desc')->get();
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('frontend.faq-author')->with('settings', $settings)->with('questions', $questions)->with('author', $author);
    }

    public function get_faq_tags($slug)
    {
        $tags = FaqTopic::where('tags', 'LIKE', '%' . $slug . '%')->orderBy('id', 'desc')->get();
        $settings = Settings::where('id', 1)->select('settings.*')->first();
        return view('frontend.faq-tags')->with('settings', $settings)->with('tags', $tags)->with('slug', $slug);
    }

    public function get_faq_question_details($topic, $slug)
    {

        $settings = Settings::where('id', 1)->select('settings.*')->first();
        $question = FaqTopic::where('slug', $slug)->first();
        return view('frontend.faq-details')->with('settings', $settings)->with('question', $question)->with('topic', $topic);
    }

    public function get_faq_title($faqTitle)
    {
        $faqs = FAQs::where('slug',$faqTitle);
        if ($faqs) {
            return redirect('/faq');
        }
    }
}
