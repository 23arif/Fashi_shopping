<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use App\Deal;
use App\FAQs;
use App\Order;
use App\PrBrand;
use App\PrCategory;
use App\Product;
use App\PrSize;
use App\Settings;
use App\Slider;
use App\User;
use App\UserExtraInfo;
use App\UserStatus;

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

    public function get_slider()
    {
        $sliderSwitch = Settings::where('id', 1)->first()->slider;
        $sliders = Slider::all();
        return view('backend.Slider.slider', ['sliders' => $sliders, 'sliderSwitch' => $sliderSwitch]);
    }

    public function get_add_slider()
    {
        return view('backend.Slider.add-slider');
    }

    public function get_edit_slider($slug)
    {
        $slider = Slider::where('slug', $slug)->first();
        return view('backend.Slider.edit-slider',['slider'=>$slider]);

    }

    public function get_products()
    {
        $tags = Product::pluck('pr_tags');


        $products = Product::all();
        $categories = PrCategory::all();
        $brands = PrBrand::all();
        $sizes = PrSize::all();
        return view('backend.products', ['tags' => $tags, 'products' => $products, 'categories' => $categories, 'brands' => $brands, 'sizes' => $sizes]);
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
        return view('backend.faq')->with('faqs', $faqs);
    }

    public function get_edit_faq($slug)
    {
        $topic = FAQs::where('slug', $slug)->first();
        return view('backend.edit-faq')->with('topic', $topic);
    }

    public function get_profile_user($username)
    {
        $id = explode('-', $username);
        $datas = User::where('id', $id[count($id) - 1])->get();
        $extraDatas = UserExtraInfo::where('user_id', $id[count($id) - 1])->get();
        return view('backend.profile', ['datas' => $datas, 'extraDatas' => $extraDatas]);
    }

    public function get_users_table()
    {
        $users = User::all();
        return view('backend.UserTable.users-table', ['users' => $users]);
    }

    public function get_edit_user($getUser)
    {
        $u = User::where('slug', $getUser)->first();
        $uStatus = $this->stt(intval($u->status));
        $allStatuses = UserStatus::all();
        return view('backend.UserTable.edit-user', ['user' => $u, 'uStatus' => $uStatus, 'allStatuses' => $allStatuses]);
    }

    private function stt($status)
    {
        if ($status === 9) {
            return 'Super Admin';
        } elseif ($status === 8) {
            return 'Admin';
        } elseif ($status === 2) {
            return 'Staff';
        } elseif ($status === 1) {
            return 'Editor';
        } elseif ($status === 0) {
            return 'User';
        }
    }

    public function get_deals()
    {
        $deals = Deal::where('id', 1)->first();
        return view('backend.Deals.edit-deal', ['deals' => $deals]);

    }

    public function get_orders_table()
    {
        $orders = Order::all()->sortByDesc('created_at');
        return view('backend.Orders.orders-table', ['orders' => $orders]);

    }

}

