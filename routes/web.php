<?php

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

Route::get('/', 'HomeGetController@get_index');
Route::get('/index', 'HomeGetController@get_index_yonlendir');
Route::get('/home', 'HomeGetController@get_index_yonlendir');
Route::get('/contact', 'HomeGetController@get_contact');
Route::get('/shop', 'HomeGetController@get_shop');
Route::get('/shopping-cart', 'HomeGetController@get_shopping_cart');
Route::get('/blog', 'HomeGetController@get_blog');
Route::get('/blog/{slug}', 'HomeGetController@get_blog_content')->where('slug','^[a-zA-Z0-9-_\/]+$');
Route::post('/blog/{slug}', 'HomePostController@post_blog_comment')->where('slug','^[a-zA-Z0-9-_\/]+$');
Route::get('/check-out', 'HomeGetController@get_checkout');
//Route::get('/login', 'HomeGetController@get_login');
Route::get('/register', 'HomeGetController@get_register');
Route::get('/product', 'HomeGetController@get_product');

Route::group(['prefix' => 'admin','middleware'=>'Admin'], function () {
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



});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
