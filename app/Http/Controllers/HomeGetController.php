<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Basket;
use App\Blog;
use App\Category;
use App\FAQs;
use App\FaqTopic;
use App\Order;
use App\PrBrand;
use App\PrCategory;
use App\PrColor;
use App\Product;
use App\ProductComment;
use App\PrSize;
use App\PrTag;
use App\Slider;
use App\User;
use App\UserExtraInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeGetController extends HomeController
{

    public function get_index()
    {
        $slides = Slider::all();
        $allProducts = Product::all();
        $banners = Banner::all();
        return view('frontend.index', ['slides' => $slides, 'allProducts' => $allProducts, 'banners' => $banners]);
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
        $recentBlogs = Blog::orderBy('id', 'desc')->get();
        $categories = Category::where('up_category', '0')->get();
        return view('frontend.blog', ['blogs' => $blogs,
            'categories' => $categories,
            'recentBlogs' => $recentBlogs
        ]);
    }

    public function get_blog_search(Request $request)
    {
        $searchedBlogs = Blog::where('title', 'LIKE', $request->get('result') . '%')->get();
        $recentBlogs = Blog::orderBy('id', 'desc')->get();
        $categories = Category::where('up_category', '0')->get();
        return view('frontend.blog', [
            'categories' => $categories,
            'recentBlogs' => $recentBlogs,
            'searchedBlogs' => $searchedBlogs
        ]);
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

        if (isset($blogs->id)) {
            $prevBlog = Blog::where('id', '<', $blogs->id)->latest('id')->first();
            $nextBlog = Blog::where('id', '>', $blogs->id)->first();
        }

        if (isset($blogs)) {
            return view('frontend.blog-details')->with(['blogs' => $blogs,
                'blogCategory' => $category,
                'prevBlog' => $prevBlog,
                'nextBlog' => $nextBlog,
            ]);
        } elseif (isset($category)) {
            $recentBlogs = Blog::orderBy('id', 'desc')->get();
            $getLastCat = $category[count($category) - 1];
            $getCat = Category::where('slug', $getLastCat)->get();
            if (count($getCat) == 0) {
                return redirect()->back();
            } else {
                $blogs = $getCat[0]->classifiedBlogs;
                return view('frontend.blog')->with(['blogs' => $blogs,
                    'categories' => $getCat,
                    'recentBlogs' => $recentBlogs,
                ]);
            }
        }
    }

    public
    function get_shop()
    {
        $products = Product::orderBy('id', 'desc');
        return view('frontend.shop', ['products' => $products]);
    }

    public
    function get_product_details($slug)
    {
        if (!is_null(Product::where('slug', $slug)->first())) {
            $products = Product::where('slug', $slug)->first();
            $userExtraData = UserExtraInfo::all();
            $payments = UserExtraInfo::all();
            $comments = ProductComment::where('product_id', $products->id)->get();
            $relatedProducts = Product::where('pr_category', $products->pr_category)->where('slug', '!=', $slug)->get();
            $productRating = round(ProductComment::where('product_id', $products->id)->avg('rating'));
            $productSizes = PrSize::where('pr_id', $products->id)->pluck('size');
            return view('frontend.product', [
                'products' => $products,
                'payments' => $payments,
                'userExtraData' => $userExtraData,
                'relatedProducts' => $relatedProducts,
                'comments' => $comments,
                'productRating' => $productRating,
                'productSizes' => $productSizes,
            ]);
        } else {
            return redirect()->back();
        }
    }

    public
    function starRating($rating)
    {
        $fullNumber = intval($rating);
        $remainder = $rating - $fullNumber;
        $emptyStar = 5 - round($rating);
        for ($i = 0; $i < $fullNumber; $i++) {
            echo '<i class="fa fa-star"></i>';
        };
        for ($k = 0; $k < $remainder; $k++) {
            echo '<i class="fa fa-star-half-empty"></i>';
        }
        for ($j = 0; $j < $emptyStar; $j++) {
            echo '<i class="fa fa-star-o"></i>';
        }
    }

    public
    function get_product_category($catName)
    {
        $getCatId = PrCategory::where('slug', $catName)->value('id');
        $products = Product::where('pr_category', $getCatId)->get();

        return view('frontend.shop-categories', ['catName' => $catName, 'products' => $products]);
    }

    public
    function get_product_brand($brandName)
    {
        if (!is_null(PrBrand::where('slug', $brandName)->first())) {
            $getBrand = PrBrand::where('slug', $brandName)->first();
            $products = Product::where('pr_brand', $getBrand->id)->get();

            return view('frontend.shop-brand', ['getBrand' => $getBrand, 'products' => $products]);
        } else {
            return redirect()->back();
        }
    }

    public
    function get_product_size($sizeName)
    {
        $getPrId = PrSize::where('size', $sizeName)->pluck('pr_id');
        $products = Product::whereIn('id',$getPrId)->get();
        return view('frontend.shop-size', ['sizeName' => $sizeName, 'products' => $products]);
    }

    public
    function get_product_tags($selectedTags)
    {
        $getProductId = PrTag::where('tag', 'LIKE', '%' . $selectedTags . '%')->first()->product_id;
        $products = Product::where('id', $getProductId)->get();

        return view('frontend.shop-tags', ['selectedTags' => $selectedTags, 'products' => $products]);
    }


    public
    function get_shopping_cart()
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $fetchToCart = Basket::where('user_id', $user_id)->get();

            return view('frontend.shopping-cart', ['fetchToCart' => $fetchToCart]);

        } else {
//            $basketArray = Cookie::get('basket');
//            return view('frontend.shopping-cart', ['basketArray' => $basketArray]);
            return view('frontend.shopping-cart');
        }

    }


    public
    function get_checkout()
    {
        return view('frontend.check-out');
    }

    public
    function get_orders(Request $request)
    {
        $user_id = Auth::id();
        $orders = Order::where('user_id', $user_id)->get();
        return view('frontend.order', ['orders' => $orders]);
    }

    public
    function get_order_details($slug)
    {
        $orderDetails = Order::where('order_no', $slug)->first();
        return view('frontend.order', ['orderDetails' => $orderDetails]);
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
        if (isset($question->id)) {
            $prevQuestion = FaqTopic::where('id', '<', $question->id)->latest('id')->first();
            $nextQuestion = FaqTopic::where('id', '>', $question->id)->first();
        }
        if (!is_null($question)) {
            return view('frontend.faq-details')->with([
                'question' => $question,
                'topic' => $topic,
                'prevQuestion' => $prevQuestion,
                'nextQuestion' => $nextQuestion
            ]);

        } else {
            return redirect()->back();
        }
    }

    public
    function get_faq_title($faqTitle)
    {
        $faqs = FAQs::where('slug', $faqTitle);
        if ($faqs) {
            return redirect('/faq');
        }
    }

    public
    function get_search(Request $request)
    {
        $result = $request->get('result');
        $products = Product::where('pr_name', 'LIKE', $result . '%')->orderBy('id', 'desc')->get();
        return view('frontend.search-result', ['products' => $products]);
    }
}
