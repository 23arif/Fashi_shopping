<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use App\Deal;
use App\FAQs;
use App\FaqTopic;
use App\PrBrand;
use App\PrCategory;
use App\PrColor;
use App\Product;
use App\PrSize;
use App\User;
use App\UserExtraInfo;
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
        $blogs = Blog::orderBy('id', 'desc')->get();
        $categories = Category::where('up_category', '0')->get();
        return view('frontend.blog', ['blogs' => $blogs, 'categories' => $categories]);
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
        $products = Product::orderBy('id', 'desc');
        $brands = PrBrand::all();
        $categories = PrCategory::all();
        $sizes = PrSize::all();
        $colors = PrColor::all();
        return view('frontend.shop', ['products' => $products, 'brands' => $brands, 'categories' => $categories, 'sizes' => $sizes, 'colors' => $colors]);
    }

    public function get_product_details($slug)
    {
        if (!is_null(Product::where('slug', $slug)->first())) {
            $products = Product::where('slug', $slug)->first();
            $userExtraData = UserExtraInfo::all();
            $brands = PrBrand::all();
            $categories = PrCategory::all();
            $sizes = PrSize::all();
            $colors = PrColor::all();
            $payments = UserExtraInfo::all();
            return view('frontend.product', ['products' => $products, 'brands' => $brands, 'categories' => $categories, 'sizes' => $sizes, 'colors' => $colors, 'payments' => $payments, 'userExtraData' => $userExtraData]);
        } else {
            return redirect()->back();
        }
    }

    public
    function get_product_category($catName)
    {
        $getCatId = PrCategory::where('slug', $catName)->value('id');
        $products = Product::where('pr_category', $getCatId)->get();
        $brands = PrBrand::all();
        $categories = PrCategory::all();
        $sizes = PrSize::all();
        $colors = PrColor::all();
        return view('frontend.shop-categories', ['catName' => $catName, 'products' => $products, 'brands' => $brands, 'categories' => $categories, 'sizes' => $sizes, 'colors' => $colors]);
    }

    public
    function get_product_brand($brandName)
    {
        if (!is_null(PrBrand::where('slug', $brandName)->first())) {
            $getBrand = PrBrand::where('slug', $brandName)->first();
            $products = Product::where('pr_brand', $getBrand->id)->get();
            $brands = PrBrand::all();
            $categories = PrCategory::all();
            $sizes = PrSize::all();
            $colors = PrColor::all();
            return view('frontend.shop-brand', ['getBrand' => $getBrand, 'products' => $products, 'brands' => $brands, 'categories' => $categories, 'sizes' => $sizes, 'colors' => $colors]);
        } else {
            return redirect()->back();
        }
    }

    public
    function get_product_size($sizeName)
    {
        $getSizeId = PrSize::where('slug', $sizeName)->value('id');
        $products = Product::where('pr_size', $getSizeId)->get();
        $brands = PrBrand::all();
        $categories = PrCategory::all();
        $sizes = PrSize::all();
        $colors = PrColor::all();
        return view('frontend.shop-size', ['sizeName' => $sizeName, 'products' => $products, 'brands' => $brands, 'categories' => $categories, 'sizes' => $sizes, 'colors' => $colors]);
    }

    public
    function get_product_tags($tags)
    {
        $products = Product::where('pr_tags', 'LIKE', '%' . $tags . '%')->get();
        $brands = PrBrand::all();
        $categories = PrCategory::all();
        $sizes = PrSize::all();
        $colors = PrColor::all();
        return view('frontend.shop-tags', ['tags' => $tags, 'products' => $products, 'brands' => $brands, 'categories' => $categories, 'sizes' => $sizes, 'colors' => $colors]);
    }

//    public function get_priceFilter($minamount,$maxamount)
//    {
//        $products = Product::whereBetween('pr_last_price', array($minamount, $maxamount));
//        return view('frontend.shop',['products'=>$products]);
//    }

    public
    function get_shopping_cart()
    {
        return view('frontend.shopping-cart');
    }

    public
    function get_checkout()
    {
        return view('frontend.check-out');
    }


    public
    function get_faq()
    {
        $faqTopics = FaqTopic::orderBy('id', 'desc')->get();
        $prime_titles = FAQs::all();
        return view('frontend.faq')->with('prime_titles', $prime_titles)->with('faqTopics', $faqTopics);
    }

    public
    function get_add_faq()
    {
        if (Auth::check() && Auth::user()->status() > 0) {
            $topics = FAQs::all();
            return view('frontend.add-faq')->with('topics', $topics);
        } else {
            return redirect('/faq');
        }

    }

    public
    function get_faq_author($slug)
    {
        $s = explode('-', $slug);
        $author = User::where('id', $s[count($s) - 1])->first();
        $questions = FaqTopic::where('author', $s[count($s) - 1])->orderBy('id', 'desc')->get();
        return view('frontend.faq-author')->with('questions', $questions)->with('author', $author);
    }

    public
    function get_faq_tags($slug)
    {
        $tags = FaqTopic::where('tags', 'LIKE', '%' . $slug . '%')->orderBy('id', 'desc')->get();
        return view('frontend.faq-tags')->with('tags', $tags)->with('slug', $slug);
    }

    public
    function get_faq_question_details($topic, $slug)
    {

        $question = FaqTopic::where('slug', $slug)->first();
        return view('frontend.faq-details')->with('question', $question)->with('topic', $topic);
    }

    public
    function get_faq_title($faqTitle)
    {
        $faqs = FAQs::where('slug', $faqTitle);
        if ($faqs) {
            return redirect('/faq');
        }
    }
}
