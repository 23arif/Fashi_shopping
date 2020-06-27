<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Comment;
use App\FaqComment;
use App\FaqTopic;
use App\Order;
use App\OrderBilling;
use App\OrderDetail;
use App\PrBrand;
use App\PrCategory;
use App\PrColor;
use App\Product;
use App\PrSize;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;


class HomePostController extends HomeController
{
    public function post_blog_comment(Request $request, $slug)
    {
        if (Auth::check()) {
            $validator = Validator::make($request->all(), [
                'content' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:250',
                'email' => 'required|email',
                'content' => 'required',
            ]);
        }
        if ($validator->fails()) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Fill the required fields !']);
        }
        $category = explode('/', $slug); //Explodes category slugs
        $request->merge(['blog' => $category[count($category) - 1]]);
        if (Auth::check()) {
            $request->merge(['user_id' => Auth::user()->id]);
        }
        Comment::create($request->all());
        return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Comment sended successfully !']);


    }

    public function post_add_faq(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prime_title' => 'required| max:250',
            'title' => 'required| max:250',
            'content' => 'required',
            'tags' => 'required'
        ]);
        $length = strlen($request->title);
        if ($length > 250) {
            return response(['processStatus' => 'warning', 'processTitle' => 'Warning', 'processDesc' => 'Question title have to be less than 250 character']);
        }
        if ($validator->fails()) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Please fill required blanks !']);
        }

        try {
            $author = Auth::user()->id;
            $date = Str::slug(Carbon::now());
            $slug = Str::slug($request->title) . '-' . $date;
            $request->merge(['slug' => $slug, 'author' => $author]);
            FaqTopic::create($request->all());
            return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Question added successfully !']);

        } catch (\Exception $e) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Question could not added !', 'error' => $e]);
        }
    }

    public function post_faq_question_comments(Request $request, $topic, $question_details)
    {
        $validator = Validator::make($request->all(), [
            'faq_content' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Fill the required fields !']);
        }
        $request->merge(['user_id' => Auth::user()->id, 'faq' => $question_details]);

        FaqComment::create($request->all());
        return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Comment sended successfully !']);


    }

    public function post_delete_faq(Request $request)
    {
        if (Auth::check() && Auth::user()->status() > 0) {
            $status = $request->status;
            if ($status == 'delete') {
                try {
                    FaqTopic::where('id', $request->id)->delete();
                    return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Question deleted successfully !']);
                } catch (\Exception $e) {
                    return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Question could not deleted !', 'error' => $e]);
                }
            } elseif ($status == 'hide') {
                try {
                    FaqTopic::where('id', $request->id)->update(['show_hide' => '0']);
                    return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Question hidded successfully !']);
                } catch (\Exception $e) {
                    return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Question could not hidded !', 'error' => $e]);
                }
            } else {
                try {
                    FaqTopic::where('id', $request->id)->update(['show_hide' => '1']);
                    return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Question showed successfully !']);
                } catch (\Exception $e) {
                    return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Question could not showed !', 'error' => $e]);
                }
            }
        } else {
            return redirect('/login');
        }
    }

    public function post_locale(Request $request)
    {
        session()->put(['locale' => $request->input('locale')]);
        App::setLocale(session()->get('locale'));
    }

    public function post_priceFilter(Request $request)
    {
        $minamount = $request->minamount;
        $maxamount = $request->maxamount;

        $minamount = str_replace('$', '', $minamount);
        $maxamount = str_replace('$', '', $maxamount);

        $products = Product::whereBetween('pr_last_price', [intval($minamount), intval($maxamount)])->get();


        $brands = PrBrand::all();
        $categories = PrCategory::all();
        $sizes = PrSize::all();
        $colors = PrColor::all();
        return view('frontend.shop', ['filteredProducts' => $products, 'brands' => $brands, 'categories' => $categories, 'sizes' => $sizes, 'colors' => $colors]);
    }

    public function post_add_to_cart(Request $request, $slug)
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $product_id = Product::where('slug', $slug)->first();


            try {
                $request->merge(['user_id' => $user_id, 'product_id' => $product_id->id]);


                if (Basket::where(['user_id' => intval($request->user_id), 'product_id' => intval($request->product_id)])->exists()) {

                    $lastQuantity = Basket::where(['user_id' => intval($request->user_id), 'product_id' => intval($request->product_id)])->first()->quantity;
                    $newQuantity = $lastQuantity + $request->quantity;
                    $total_price_per_product = $product_id->pr_last_price * intval($newQuantity);

                    Basket::where(['user_id' => intval($request->user_id), 'product_id' => intval($request->product_id)])->update(['quantity' => $newQuantity, 'total_price_per_product' => $total_price_per_product]);
                    return back()->with('addToCartMsg', 'Product added to cart successfully !');
                } else {
                    $total_price_per_product = $product_id->pr_last_price * $request->quantity;
                    $request->merge(['total_price_per_product' => $total_price_per_product]);

                    Basket::create($request->all());
                    return back()->with('addToCartMsg', 'Product added to cart successfully !');
                }
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Could not added to cart!', 'error' => $e]);
            }
        } else {
            return 'not registeredd';
        }
    }

    public function post_add_to_cart_icon(Request $request)
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $product_id = Product::where('slug', $request->slug)->first();

            try {
                $request->merge(['user_id' => $user_id, 'product_id' => $product_id->id, 'quantity' => 1]);


                if (Basket::where(['user_id' => intval($request->user_id), 'product_id' => intval($request->product_id)])->exists()) {

                    $lastQuantity = Basket::where(['user_id' => intval($request->user_id), 'product_id' => intval($request->product_id)])->first()->quantity;
                    $newQuantity = $lastQuantity + $request->quantity;
                    $total_price_per_product = $product_id->pr_last_price * intval($newQuantity);

                    Basket::where(['user_id' => intval($request->user_id), 'product_id' => intval($request->product_id)])->update(['quantity' => $newQuantity, 'total_price_per_product' => $total_price_per_product]);
                } else {
                    $total_price_per_product = $product_id->pr_last_price * $request->quantity;
                    $request->merge(['total_price_per_product' => $total_price_per_product]);

                    Basket::create($request->all());
                    return response(['increase' => 'increase']);
                }
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Could not added to cart!', 'error' => $e]);
            }
        } else {
            return 'not registered';
        }
    }

    public function post_shopping_cart(Request $request)
    {
        if ($request->identifier == 'deleteSelectedProduct') {
            try {
                Basket::where(['user_id' => Auth::id(), 'product_id' => $request->product_id])->delete();
                return response(['processStatus' => 'success']);

            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Could not deleted!', 'error' => $e]);
            }

        } elseif ($request->identifier == 'decQtyy') {
            try {
                if ($request->newDecreasedQty == 'deleteProduct') {
                    Basket::where(['user_id' => Auth::id(), 'product_id' => $request->pr_id])->delete();
                } else {
                    Basket::where(['user_id' => Auth::id(), 'product_id' => $request->pr_id])->update(['quantity' => $request->newDecreasedQty]);
                }
            } catch (\Exception $e) {
                return response(['error' => $e]);
            }

        } elseif ($request->identifier == 'incQtyy') {
            try {
                Basket::where(['user_id' => Auth::id(), 'product_id' => $request->pr_id])->update(['quantity' => $request->newIncreasedQty]);
            } catch (\Exception $e) {
                return response(['error' => $e]);
            }
        } elseif ($request->identifier == 'typeQty') {
            try {
                Basket::where(['user_id' => Auth::id(), 'product_id' => $request->product_id])->update(['quantity' => $request->typedQty]);
            } catch (\Exception $e) {
                return response(['error' => $e]);
            }
        }
    }

    public function post_checkout(Request $request)
    {
        $messages = [
            'billing_first_name.required' => 'The First Name field is required.',
            'billing_last_name.required' => 'The Last Name field is required.',
            'billing_country.required' => 'The Country field is required.',
            'billing_street_1.required' => 'The Street Address field is required.',
            'billing_zip.required' => 'The Postalcode / ZIP field is required.',
            'billing_town.required' => 'The Town / City field is required.',
            'billing_email.required' => 'The Email address field is required.',
            'billing_email.email' => 'The Email address must be a valid email address..',
            'billing_phone.required' => 'The Phone field is required.',
            'max' => 'The content may not be greater than :max characters.',
        ];
        $validator = Validator::make($request->all(), [
            'billing_first_name' => 'required|max:100',
            'billing_last_name' => 'required|max:100',
            'billing_country' => 'required|max:100',
            'billing_street_1' => 'required|max:100',
            'billing_street_2' => 'max:100',
            'billing_zip' => 'required|max:10',
            'billing_town' => 'required|max:100',
            'billing_email' => 'required|email|max:150',
            'billing_phone' => 'required|max:20',
        ], $messages);

        if ($validator->fails()) {
            $validator->validate();
            return back()->withInput();
        }

        try {
            $user_id = Auth::id();
            $order_no = rand(1111111111, 9999999999);
            $totalPrice = 0;
            foreach (Basket::where('user_id', $user_id)->get() as $fetch) {
                $totalPrice += $fetch->getProductInfo->pr_last_price * $fetch->quantity;
            };
            $request->merge(['user_id' => $user_id, 'order_no' => $order_no, 'order_total' => $totalPrice]);
            $newOrder = Order::create($request->all());
            if ($newOrder) {
                $getBasketProducts = Basket::where('user_id', $user_id)->get();
                foreach ($getBasketProducts as $getBasketProduct) {
                    $newOrderDetails = OrderDetail::create(['order_no' => $order_no, 'pr_id' => $getBasketProduct->product_id, 'pr_price' => $getBasketProduct->getProductInfo->pr_last_price, 'pr_quantity' => $getBasketProduct->quantity]);
                }
                if ($newOrderDetails) {
                    Basket::where('user_id', $user_id)->delete();
                    $request->merge(['order_no' => $order_no]);
                    OrderBilling::create($request->all());
                    return redirect(route('ordersPage'))->with('orderSession', 'Order completed succesfully!');
                }
            }

        } catch (\Exception $e) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Order could not completed !', 'error' => $e]);
        }
    }


}
