<?php

namespace App\Http\Controllers\Auth;

use App\Basket;
use App\Locale;
use App\PrCategory;
use App\Settings;
use Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\View;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function showLoginForm()
    {
        $settings = Settings::all();
        $locales = Locale::all();
        $allDepartments = PrCategory::all();

        $fullUrl = url()->current();
        $currentUrl = explode('/', $fullUrl);
        if (!isset($currentUrl[3])) {
            $activeUrl ='127.0.0.1:8000';
        }else{
            $activeUrl =$currentUrl[3];
        }

        $cartProducts = Basket::where('user_id', \Illuminate\Support\Facades\Auth::id())->get();
        $totalPrice = 0;

        foreach (Basket::where('user_id', Auth::id())->get() as $fetch) {
            $totalPrice += $fetch->getProductInfo->pr_last_price * $fetch->quantity;
        }


        View::share([
            'settings' => $settings,
            'locales' => $locales,
            'allDepartments' => $allDepartments,
            'activeUrl' => $activeUrl,
            'cartProducts' => $cartProducts, 'totalPrice' => $totalPrice
        ]);


        return view('frontend.login');;
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated($request, $user)
    {
        if($user->status >0) {
            return redirect()->intended('admin');
        }
    }
}
