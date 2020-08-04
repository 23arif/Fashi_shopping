<?php

use Illuminate\Support\Facades\Auth;
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
Route::get('/', 'HomeController@index');
Route::get('/', 'HomeGetController@get_index')->name('homePage');
Route::get('/index', 'HomeGetController@get_index_yonlendir');
Route::post('/locale', 'HomePostController@post_locale');
Route::get('/home', 'HomeGetController@get_index_yonlendir');
Route::get('/search', 'HomeGetController@get_search')->name('searchPage');

Route::group(['prefix' => 'contact'], function () {
    Route::get('/', 'HomeGetController@get_contact')->name('contactPage');
    Route::post('/', 'HomePostController@post_contact_comment')->name('commentPost');
});

Route::group(['prefix' => 'shop'], function () {
    Route::get('/', 'HomeGetController@get_shop')->name('shopPage');
    Route::post('/', 'HomePostController@post_add_to_cart_icon')->name('addToCartIcon');
    Route::post('/priceFilter', 'HomePostController@post_priceFilter')->name('priceFilter');
    Route::get('/product-details/{slug}', 'HomeGetController@get_product_details');
    Route::post('/product-details/{slug}', 'HomePostController@post_add_to_cart')->name('addToCart');
    Route::post('/product-details/{slug}/comment', 'HomePostController@post_product_comment')->name('productComment');
    Route::get('/category/{catName}', 'HomeGetController@get_product_category')->name('prCategory');
    Route::get('/size/{sizeName}', 'HomeGetController@get_product_size');
    Route::get('/tags/{tags}', 'HomeGetController@get_product_tags');
    Route::get('/brand/{brandName}', 'HomeGetController@get_product_brand');
    Route::get('/shopping-cart', 'HomeGetController@get_shopping_cart')->name('shoppingCartPage');
    Route::post('/shopping-cart', 'HomePostController@post_shopping_cart')->name('postShoppingCart');
    Route::get('/check-out', 'HomeGetController@get_checkout')->name('checkoutPage')->middleware('GoToCheckOut');
    Route::post('/check-out', 'HomePostController@post_checkout')->name('checkoutPost');
    Route::get('/orders', 'HomeGetController@get_orders')->name('ordersPage')->middleware('CheckRegister');

});

Route::group(['prefix' => 'blog'], function () {
    Route::get('/', 'HomeGetController@get_blog')->name('blogPage');
//    Route::get('?result={result}', 'HomeGetController@get_blog_search');
    Route::get('/author/{authorName}', 'HomeGetController@get_blog_author')->name('blogAuthorName');
    Route::get('/tags/{tagName}', 'HomeGetController@get_blog_tags');
    Route::get('/search', 'HomeGetController@get_blog_search')->name('blogSearch');
    Route::get('/{slug}', 'HomeGetController@get_blog_content')->where('slug', '^[a-zA-Z0-9-_\/]+$');
    Route::post('/{slug}', 'HomePostController@post_blog_comment')->where('slug', '^[a-zA-Z0-9-_\/]+$');
});
Route::get('/login', 'HomeGetController@showLoginForm');
Route::get('/register', 'HomeGetController@showRegistrationForm');

Route::group(['prefix' => 'faq'], function () {
    Route::get('/', 'HomeGetController@get_faq')->name('faqPage');
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

    Route::get('/', 'AdminGetController@get_index')->name('adminIndex');
    Route::get('/settings', 'AdminGetController@get_settings')->name('adminSettingsPage');
    Route::post('/settings', 'AdminPostController@post_settings');

    Route::group(['prefix' => 'slider'], function () {
        Route::get('/', 'AdminGetController@get_slider')->name('sliderPage');
        Route::post('/', 'AdminPostController@slider_switcher_and_dlt')->name('slider_switcher_and_dlt');
        Route::get('/add-slider', 'AdminGetController@get_add_slider')->name('addSlider');
        Route::post('/add-slider', 'AdminPostController@post_add_slider');
        Route::get('/edit-slider/{sliderSlug}', 'AdminGetController@get_edit_slider')->name('editSlider');
        Route::post('/edit-slider/{sliderSlug}', 'AdminPostController@post_edit_slider')->name('editSlider');

    });
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', 'AdminGetController@get_products')->name('adminProductsPage');
        Route::post('/', 'AdminPostController@post_products');

    });
    Route::group(['prefix' => 'blog'], function () {
        Route::get('/', 'AdminGetController@get_blog')->name('adminBlogPage');
        Route::post('/', 'AdminPostController@post_blog');
        Route::get('/edit-blog/{slug}', 'AdminGetController@get_edit_blog');
        Route::post('/edit-blog/{slug}', 'AdminPostController@post_edit_blog');
    });
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'AdminGetController@get_category')->name('adminCategoryPage');
        Route::post('/', 'AdminPostController@post_category');

    });
    Route::group(['prefix' => 'faq'], function () {
        Route::get('/', 'AdminGetController@get_faq')->name('adminFaqPage');
        Route::post('/', 'AdminPostController@post_faq');
        Route::get('/edit-faq/{slug}', 'AdminGetController@get_edit_faq');
        Route::post('/edit-faq/{slug}', 'AdminPostController@post_edit_faq');

    });
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/{username}', 'AdminGetController@get_profile_user');
        Route::post('/{username}', 'AdminPostController@post_profile_user');

    });
    Route::group(['prefix' => 'deals'], function () {
        Route::get('/', 'AdminGetController@get_deals')->name('getDeal');
        Route::post('/', 'AdminPostController@post_deals')->name('postDeal');
        Route::post('/switch-deal', 'AdminPostController@post_switch_deal')->name('switchDeal');

    });
    Route::group(['prefix' => 'users-table', 'middleware' => 'OnlySuperAdmin'], function () {
        Route::get('/', 'AdminGetController@get_users_table')->name('getUserTable');
        Route::post('/', 'AdminPostController@post_delete_user')->name('deleteUser');
        Route::get('/edit-user/{getUser}', 'AdminGetController@get_edit_user')->name('getEditUser');
        Route::post('/edit-user/{getUser}', 'AdminPostController@post_edit_user')->name('postEditUser');


    });
    Route::group(['prefix' => 'banners'], function () {
        Route::get('/', 'AdminGetController@get_banners')->name('getBanners');
        Route::get('/update-banner/{banner}', 'AdminGetController@get_update_banner')->name('updateBanner');
        Route::post('/update-banner/{banner}', 'AdminPostController@post_update_banner')->name('postUpdateBanner');
    });
    Route::group(['prefix' => 'orders', 'middleware' => 'OnlySuperAdmin'], function () {
        Route::get('/', 'AdminGetController@get_orders_table')->name('getOrdersTable');

    });

    Route::group(['prefix' => 'messages'], function () {
        Route::get('/', 'AdminGetController@get_messages_table')->name('adminMessagesPage');
        Route::post('/', 'AdminPostController@post_delete_message')->name('deleteMessage');
        Route::get('/{slug}', 'AdminGetController@get_read_message')->name('readMessage');

    });


});


Auth::routes();


