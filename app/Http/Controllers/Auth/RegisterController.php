<?php

namespace App\Http\Controllers\Auth;

use App\Basket;
use App\Http\Controllers\Controller;
use App\Locale;
use App\PrCategory;
use App\Providers\RouteServiceProvider;
use App\Settings;
use App\User;
use App\UserExtraInfo;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function showRegistrationForm()
    {
        $settings = Settings::all();
        $locales = Locale::all();
        $allDepartments = PrCategory::all();
        $basketArray = Cookie::get('basket');


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
            'cartProducts' => $cartProducts,
            'totalPrice' => $totalPrice,
            'basketArray' => $basketArray,

        ]);

        return view('frontend.register');
    }

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $newUser =  User::create([
            'name' => strip_tags($data['name']),
            'email' => strip_tags($data['email']),
            'password' => Hash::make($data['password']),
            'slug' => str::slug(strip_tags($data['name'])) . '-' . rand(1, 9999),

        ]);
        $id = $newUser->id;
        UserExtraInfo::create(['user_id'=>$id]);
        return $newUser;
    }
}
