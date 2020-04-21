<?php

use App\Settings;
use App\Locale;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
view()->composer('*', function ($view) {
    $locale = Locale::all();
    $view->with(['settings' => $settings = Settings::all(),'locale'=> $locale]);
});


Route::get('/', 'HomeGetController@get_index');
Route::get('/index', 'HomeGetController@get_index_yonlendir');
Route::post('/locale', 'HomePostController@post_locale');
Route::get('/home', 'HomeGetController@get_index_yonlendir');
Route::get('/contact', 'HomeGetController@get_contact');
Route::get('/shop', 'HomeGetController@get_shop');
Route::get('/shopping-cart', 'HomeGetController@get_shopping_cart');
Route::group(['prefix' => 'blog'], function () {
    Route::get('/', 'HomeGetController@get_blog');
    Route::get('/author/{authorName}', 'HomeGetController@get_blog_author');
    Route::get('/tags/{tagName}', 'HomeGetController@get_blog_tags');
    Route::get('/{slug}', 'HomeGetController@get_blog_content')->where('slug', '^[a-zA-Z0-9-_\/]+$');
    Route::post('/{slug}', 'HomePostController@post_blog_comment')->where('slug', '^[a-zA-Z0-9-_\/]+$');
});
Route::get('/check-out', 'HomeGetController@get_checkout');
Route::get('/login', 'HomeGetController@showLoginForm');
Route::get('/register', 'HomeGetController@showRegistrationForm');
Route::get('/product', 'HomeGetController@get_product');
Route::group(['prefix' => 'faq'], function () {
    Route::get('/', 'HomeGetController@get_faq');
    Route::get('/add-faq', 'HomeGetController@get_add_faq');
    Route::post('/add-faq', 'HomePostController@post_add_faq');
    Route::post('/delete-faq', 'HomePostController@post_delete_faq');
    Route::get('/{faqTitle}', 'HomeGetController@get_faq_title');
    Route::get('/author/{slug}', 'HomeGetController@get_faq_author');
    Route::get('/tags/{slug}', 'HomeGetController@get_faq_tags');
    Route::get('/{topic}/{question_details}', 'HomeGetController@get_faq_question_details');
    Route::post('/{topic}/{question_details}', 'HomePostController@post_faq_question_comments');
});


Route::group(['prefix' => 'admin', 'middleware' => 'Admin'], function () {
    Route::get('/', 'AdminGetController@get_index');
    Route::get('/settings', 'AdminGetController@get_settings');
    Route::post('/settings', 'AdminPostController@post_settings');


    Route::group(['prefix' => 'blog'], function () {
        Route::get('/', 'AdminGetController@get_blog');
        Route::post('/', 'AdminPostController@post_blog');
        Route::get('/edit-blog/{slug}', 'AdminGetController@get_edit_blog');
        Route::post('/edit-blog/{slug}', 'AdminPostController@post_edit_blog');
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'AdminGetController@get_category');
        Route::post('/', 'AdminPostController@post_category');

    });
    Route::group(['prefix' => 'faq'], function () {
        Route::get('/', 'AdminGetController@get_faq');
        Route::post('/', 'AdminPostController@post_faq');
        Route::get('/edit-faq/{slug}', 'AdminGetController@get_edit_faq');
        Route::post('/edit-faq/{slug}', 'AdminPostController@post_edit_faq');

    });


});


Auth::routes();

Route::get('/', 'HomeController@index');
