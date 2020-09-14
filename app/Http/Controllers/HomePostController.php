<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Comment;
use App\ContactComment;
use App\FaqComment;
use App\FaqTopic;
use App\Mail\ContactMail;
use App\Order;
use App\OrderBilling;
use App\OrderDetail;
use App\Product;
use App\ProductComment;
use App\PrStock;
use App\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Validator;


class HomePostController extends HomeController
{
    public function post_blog_comment(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['processStatus' => 'warning', 'processTitle' => 'Warning', 'processDesc' => 'Fill the required fields !']);
        }
        $category = explode('/', $slug); //Explodes category slugs
        $request->merge(['blog' => $category[count($category) - 1], 'user_id' => Auth::user()->id]);
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
            return response(['processStatus' => 'warning', 'processTitle' => 'Warning', 'processDesc' => 'Please fill required blanks !']);
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
            return response(['processStatus' => 'warning', 'processTitle' => 'Warning', 'processDesc' => 'Fill the required fields !']);
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
                    $getFaqTopicSlug = FaqTopic::where('id', $request->id)->first()->slug;
                    $deletingFaqTopic = FaqTopic::where('id', $request->id)->delete();
                    if ($deletingFaqTopic) {
                        FaqComment::where('faq', $getFaqTopicSlug)->delete();
                        return response(['processStatus' => 'success', 'processTitle' => 'Successful', 'processDesc' => 'Question deleted successfully !']);
                    }
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


        return view('frontend.shop', [
            'filteredProducts' => $products,
            'filteredMaxAmount' => $maxamount,
            'filteredMinAmount' => $minamount
        ]);
    }

    public function post_add_to_cart(Request $request, $slug)
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $product_id = Product::where('slug', $slug)->first();
            $pr_stock = PrStock::where('pr_id', $product_id->id)->first()->stock;
            if ($pr_stock > 0 and $pr_stock >= $request->quantity) {
                try {
                    $request->merge(['user_id' => $user_id, 'product_id' => $product_id->id]);


                    if (Basket::where(['user_id' => intval($request->user_id), 'product_id' => intval($request->product_id)])->exists()) {
                        if (Basket::where(['user_id' => intval($request->user_id), 'product_id' => intval($request->product_id), 'pr_size' => $request->pr_size])->exists()) {
                            $lastQuantity = Basket::where(['user_id' => intval($request->user_id), 'product_id' => intval($request->product_id), 'pr_size' => $request->pr_size])->first()->quantity;
                            $newQuantity = $lastQuantity + $request->quantity;

                            $orderedProduct = Basket::where(['user_id' => intval($request->user_id), 'product_id' => intval($request->product_id), 'pr_size' => $request->pr_size])->update(['quantity' => $newQuantity]);

                            if ($orderedProduct) {
                            }
                            PrStock::where('pr_id', $product_id->id)->update(['stock' => $pr_stock - $request->quantity]);
                            return back()->with('addToCartMsg', 'Product added to cart successfully !');
                        } else {
                            $orderedProduct = Basket::create($request->all());
                            if ($orderedProduct) {
                                PrStock::where('pr_id', $product_id->id)->update(['stock' => $pr_stock - $request->quantity]);
                            }
                            return back()->with('addToCartSuccessMsg', 'Product added to cart successfully !');
                        }
                    } else {
                        $orderedProduct = Basket::create($request->all());
                        if ($orderedProduct) {
                            PrStock::where('pr_id', $product_id->id)->update(['stock' => $pr_stock - $request->quantity]);
                        }
                        return back()->with('addToCartSuccessMsg', 'Product added to cart successfully !');
                    }
                } catch (\Exception $e) {
                    return back()->with('addToCartWarningMsg', 'Please provide the missing information first!');
                }
            } else {
                return back()->with('addToCartInfoMsg', 'Unfortunately, the product that you want to order is now out-of-stock.');

            }
        } else {
            return 'not registeredd';
        }
    }

//    public function post_add_to_cart_icon(Request $request)
//    {
//        if (Auth::check()) {
//            $user_id = Auth::id();
//            $product_id = Product::where('slug', $request->slug)->first();
//
//            try {
//                $request->merge(['user_id' => $user_id, 'product_id' => $product_id->id, 'quantity' => 1]);
//
//
//                if (Basket::where(['user_id' => intval($request->user_id), 'product_id' => intval($request->product_id)])->exists()) {
//
//                    $lastQuantity = Basket::where(['user_id' => intval($request->user_id), 'product_id' => intval($request->product_id)])->first()->quantity;
//                    $newQuantity = $lastQuantity + $request->quantity;
//                    $total_price_per_product = $product_id->pr_last_price * intval($newQuantity);
//
//                    Basket::where(['user_id' => intval($request->user_id), 'product_id' => intval($request->product_id)])->update(['quantity' => $newQuantity, 'total_price_per_product' => $total_price_per_product]);
//                } else {
//                    $total_price_per_product = $product_id->pr_last_price * $request->quantity;
//                    $request->merge(['total_price_per_product' => $total_price_per_product]);
//
//                    Basket::create($request->all());
//                    return response(['increase' => 'increase']);
//                }
//            } catch (\Exception $e) {
//                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Could not added to cart!', 'error' => $e]);
//            }
//        } else {
//            try {
//                $product_id = Product::where('slug', $request->slug)->first()->id;
//                $basket = Cookie::get('basket');
//                if (empty($basket)) {
//                    Cookie::queue('basket[' . $product_id . ']', '1', strtotime('+1 day'));
//                    return response(['increase' => 'increase']);
//                } else {
//                    foreach ($basket as $key => $value) {
//                        if ($key == $product_id) {
//                            return 'increased qty';
//                        } elseif (empty($basket)) {
//                            Cookie::queue('basket[' . $product_id . ']', '1', strtotime('+1 day'));
//                            return response(['increase' => 'increase']);
//
//                        } else {
//                            Cookie::queue('basket[' . $product_id . ']', '1', strtotime('+1 day'));
//                            return response(['increase' => 'increase']);
//                        }
//                    }
//                }
//
//            } catch (\Exception $e) {
//                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Could not added to cart!', 'error' => $e]);
//            }
//        }
//    }

    public function post_shopping_cart(Request $request)
    {
        if ($request->identifier == 'deleteSelectedProduct') {
            $stock = PrStock::where(['pr_id' => $request->product_id])->first()->stock;
            $getQty = Basket::where(['user_id' => Auth::id(), 'product_id' => $request->product_id, 'pr_size' => $request->pr_size])->first()->quantity;
            try {
                $process = Basket::where(['user_id' => Auth::id(), 'product_id' => $request->product_id, 'pr_size' => $request->pr_size])->delete();
                if ($process) {
                    PrStock::where(['pr_id' => $request->product_id])->update(['stock' => $stock + $getQty]);
                }
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Something goes wrong. Please try later!']);
            }

        } elseif ($request->identifier == 'decQtyy') {
            $stock = PrStock::where(['pr_id' => $request->pr_id])->first()->stock;
            try {
                if ($request->newDecreasedQty == 'deleteProduct') {
                    $process = Basket::where(['user_id' => Auth::id(), 'product_id' => $request->pr_id, 'pr_size' => $request->pr_size])->delete();
                    if ($process) {
                        PrStock::where(['pr_id' => $request->pr_id])->update(['stock' => $stock + 1]);
                    }
                } else {
                    $process = Basket::where(['user_id' => Auth::id(), 'product_id' => $request->pr_id, 'pr_size' => $request->pr_size])->update(['quantity' => $request->newDecreasedQty]);
                    if ($process) {
                        PrStock::where(['pr_id' => $request->pr_id])->update(['stock' => $stock + 1]);
                    }
                }
            } catch (\Exception $e) {
                return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Something goes wrong. Please try later !']);
            }

        } elseif ($request->identifier == 'incQtyy') {
            $stock = PrStock::where(['pr_id' => $request->pr_id])->first()->stock;
            if ($stock >= 1) {
                try {
                    $process = Basket::where(['user_id' => Auth::id(), 'product_id' => $request->pr_id, 'pr_size' => $request->pr_size])->update(['quantity' => $request->newIncreasedQty]);
                    if ($process) {
                        PrStock::where(['pr_id' => $request->pr_id])->update(['stock' => $stock - 1]);
                        return response(['processStatus' => 'success']);
                    }
                } catch (\Exception $e) {
                    return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Something goes wrong. Please try later !']);
                }
            } else {
                return response(['processStatus' => 'info', 'processTitle' => 'Information', 'processDesc' => 'Unfortunately, the product that you want to increase quantity is now out-of-stock.']);
            }
        } elseif ($request->identifier == 'typeQty') {
            $stock = PrStock::where(['pr_id' => $request->product_id])->first()->stock;
            $currentQty = Basket::where(['user_id' => Auth::id(), 'product_id' => $request->product_id, 'pr_size' => $request->pr_size])->first()->quantity; //The current quantity,which selected product desc. page.
            $differenceLastAndNewQty = $request->typedQty - $currentQty;
            if ($request->typedQty == 0) {
//                Delete product
                if (is_null($request->typedQty)) {
                    return response(['processStatus' => 'warning', 'processTitle' => 'Warning', 'processDesc' => 'Nothing typed to process.']);
                } else {
                    try {
                        $process = Basket::where(['user_id' => Auth::id(), 'product_id' => $request->product_id, 'pr_size' => $request->pr_size])->delete();
                        if ($process) {
                            PrStock::where(['pr_id' => $request->product_id])->update(['stock' => $stock + $currentQty]);
                        }
                    } catch (\Exception $e) {
                        return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Something goes wrong. Please try later !']);
                    }
                }

            } elseif ($stock >= $differenceLastAndNewQty and $differenceLastAndNewQty > 0) {
//                Decrease stock , increase quantity
                try {
                    $process = Basket::where(['user_id' => Auth::id(), 'product_id' => $request->product_id, 'pr_size' => $request->pr_size])->update(['quantity' => $request->typedQty]);
                    if ($process) {
                        PrStock::where(['pr_id' => $request->product_id])->update(['stock' => $stock - $differenceLastAndNewQty]);
                    }
                } catch (\Exception $e) {
                    return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Something goes wrong. Please try later !']);
                }
            } elseif ($stock >= $differenceLastAndNewQty and $differenceLastAndNewQty < 0) {
//                Increase stock , decrease quantity
                try {
                    $process = Basket::where(['user_id' => Auth::id(), 'product_id' => $request->product_id, 'pr_size' => $request->pr_size])->update(['quantity' => $request->typedQty]);
                    if ($process) {
                        PrStock::where(['pr_id' => $request->product_id])->update(['stock' => $stock + abs($differenceLastAndNewQty)]);
                    }
                } catch (\Exception $e) {
                    return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Something goes wrong. Please try later !']);
                }
            } elseif ($stock < $differenceLastAndNewQty) {
                return response(['processStatus' => 'info', 'processTitle' => 'Information', 'processDesc' => 'Unfortunately, the product that you want to increase quantity is now out-of-stock.']);
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
            $order_no = rand(11111111, 99999999);

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
                    return redirect(route('ordersPage'))->with('orderSession', 'Orders completed succesfully!');
                }
            }

        } catch (\Exception $e) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Orders could not completed !', 'error' => $e]);
        }
    }

    public function post_contact_comment(Request $request)
    {
        if (Auth::check()) {
            $validator = Validator::make($request->all(), [
                'message' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required| max:190',
                'email' => 'required| email |max:190',
                'message' => 'required',
            ]);
        }


        if ($validator->fails()) {
            return response(['processStatus' => 'warning', 'processTitle' => 'Warning', 'processDesc' => 'Please fill required blanks !']);
        }

        try {
            if (Auth::check()) {
                $request->merge(['name' => Auth::user()->name, 'email' => Auth::user()->email]);
            }
            $systemInfo = Settings::where('id', 1)->first();

            $data = array(
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message
            );
            Mail::to($systemInfo->mail)->send(new ContactMail($data));


//            Save messages to database
            $slug = Str::slug($request->name . '-' . now());
            $request->merge(['slug' => $slug]);
            ContactComment::create($request->all());


//            Mail::send([], [], function ($message) use ($date, $request) {
//                $systemInfo = Settings::where('id', 1)->first();
//                $message->from($request->email, $request->name);
//                $message->to($systemInfo->mail);
//                $message->setBody('Message from :' . $request->name . '<br/>
//                                   Sender mail :' . $request->email . '<br/>
//                                   Message content :' . $request->message . '<br/>
//                                   Message date :' . $date, 'text/html');
//                $message->subject('Message from : ' . $request->name);
//            });

            return response(['processStatus' => 'success', 'processTitle' => 'Successfully', 'processDesc' => 'Comment sent successfully !']);
        } catch (\Exception $e) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Comment could not sent !', 'error' => $e]);
        }
    }

    public function post_product_comment(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['processStatus' => 'warning', 'processTitle' => 'Warning', 'processDesc' => 'Please fill required blanks !']);
        }

        try {
            $user_id = Auth::id();
            $product_id = Product::where('slug', $slug)->first()->id;
            $request->merge(['user_id' => $user_id, 'product_id' => $product_id, 'comment' => $request->message]);
            ProductComment::create($request->all());
            return response(['processStatus' => 'success', 'processTitle' => 'Successfully', 'processDesc' => 'Comment sent successfully !']);

        } catch (\Exception $e) {
            return response(['processStatus' => 'error', 'processTitle' => 'Error', 'processDesc' => 'Comment could not sent !', 'error' => $e]);
        }
    }


}
