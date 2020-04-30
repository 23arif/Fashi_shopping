<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use App\FAQs;
use App\FaqTopic;
use App\PrBrand;
use App\PrCategory;
use App\PrColor;
use App\Product;
use App\PrSize;
use App\Settings;
use App\User;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;

class HomeGetController extends HomeController
{

    public function get_index()
    {
        return view('frontend.index');
    }

    public function get_index_yonlendir()
    {
        return redirect('/');
    }

    public function get_contact()
    {
        return view('frontend.contact');
    }

    public function get_blog()
    {
        $blogs = Blog::orderBy('id', 'desc')->paginate(6);
        $categories = Category::where('up_category', '0')->get();
        return view('frontend.blog')->with('blogs', $blogs)->with('categories', $categories);
    }

    public function get_blog_author($authorName)
    {
        $y = explode('-', $authorName);
        $blogs = Blog::where('author', $y[count($y) - 1])->orderBy('id', 'desc')->get();
        $categories = Category::where('up_category', '0')->get();
        return view('frontend.blog')->with('blogs', $blogs)->with('categories', $categories);
    }

    public function get_blog_tags($tagName)
    {
        $blogs = Blog::where('tags', 'LIKE', '%' . $tagName . '%')->orderBy('id', 'desc')->get();
        $categories = Category::where('up_category', '0')->get();
        return view('frontend.blog')->with('blogs', $blogs)->with('categories', $categories);
    }

    public function get_blog_content($slug)
    {
        $category = explode('/', $slug); //Explodes category slugs
        $blogs = Blog::where('slug', $category[count($category) - 1])->first();
        if (isset($blogs)) {
            return view('frontend.blog-details')->with('blogs', $blogs)->with('blogCategory', $category);
        } else {
            $getLastCat = $category[count($category) - 1];
            $getCat = Category::where('slug', $getLastCat)->get();
            $blogs = $getCat[0]->classifiedBlogs;
            return view('frontend.blog')->with('blogs', $blogs)->with('categories', $getCat);

        }

    }

    public function get_shop()
    {
        $products = Product::all();
        $brands = PrBrand::all();
        $categories = PrCategory::all();
        $sizes = PrSize::all();
        $colors = PrColor::all();
        return view('frontend.shop',['products'=>$products,'brands'=>$brands,'categories'=>$categories,'sizes'=>$sizes,'colors'=>$colors]);
    }

    public function get_product_details()
    {
        $products = Product::all();
        $brands = PrBrand::all();
        $categories = PrCategory::all();
        $sizes = PrSize::all();
        $colors = PrColor::all();
        return view('frontend.product',['products'=>$products,'brands'=>$brands,'categories'=>$categories,'sizes'=>$sizes,'colors'=>$colors]);;
    }


    public function get_shopping_cart()
    {
        return view('frontend.shopping-cart');
    }

    public function get_checkout()
    {
        return view('frontend.check-out');
    }


    public function get_faq()
    {
        $faqTopics = FaqTopic::orderBy('id', 'desc')->get();
        $prime_titles = FAQs::all();
        return view('frontend.faq')->with('prime_titles', $prime_titles)->with('faqTopics', $faqTopics);
    }

    public function get_add_faq()
    {
        if (Auth::check() && Auth::user()->status() > 0) {
            $topics = FAQs::all();
            return view('frontend.add-faq')->with('topics', $topics);
        } else {
            return redirect('/faq');
        }

    }

    public function get_faq_author($slug)
    {
        $s = explode('-', $slug);
        $author = User::where('id', $s[count($s) - 1])->first();
        $questions = FaqTopic::where('author', $s[count($s) - 1])->orderBy('id', 'desc')->get();
        return view('frontend.faq-author')->with('questions', $questions)->with('author', $author);
    }

    public function get_faq_tags($slug)
    {
        $tags = FaqTopic::where('tags', 'LIKE', '%' . $slug . '%')->orderBy('id', 'desc')->get();
        return view('frontend.faq-tags')->with('tags', $tags)->with('slug', $slug);
    }

    public function get_faq_question_details($topic, $slug)
    {

        $question = FaqTopic::where('slug', $slug)->first();
        return view('frontend.faq-details')->with('question', $question)->with('topic', $topic);
    }

    public function get_faq_title($faqTitle)
    {
        $faqs = FAQs::where('slug', $faqTitle);
        if ($faqs) {
            return redirect('/faq');
        }
    }
}
