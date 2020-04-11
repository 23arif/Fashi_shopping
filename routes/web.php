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
Route::get('/blog/blog-details', 'HomeGetController@get_blog_details');
Route::get('/check-out', 'HomeGetController@get_checkout');
Route::get('/login', 'HomeGetController@get_login');
Route::get('/register', 'HomeGetController@get_register');
Route::get('/product', 'HomeGetController@get_product');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminGetController@get_index');
    Route::get('/settings', 'AdminGetController@get_settings');
    Route::post('/settings', 'AdminPostController@post_settings');
    Route::get('/blog', 'AdminGetController@get_blog');
    Route::post('/blog', 'AdminPostController@post_blog');


});
