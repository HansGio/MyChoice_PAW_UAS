<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Email Verification
Route::get('email/verify/{id}', 'Api\VerificationController@verify')->name('verificationapi.verify');
Route::get('email/resend', 'Api\VerificationController@resend')->name('verificationapi.resend');

// User
Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('logout', 'Api\AuthController@logout');
    Route::get('details', 'Api\AuthController@details');
    Route::put('update', 'Api\AuthController@update');

    // Item
    Route::get('item', 'Api\ItemController@index');
    Route::get('item/{id}', 'Api\ItemController@show');
    Route::post('item', 'Api\ItemController@store');
    Route::put('item/{id}', 'Api\ItemController@update');
    Route::delete('item/{id}', 'Api\ItemController@destroy');

    // Order
    Route::get('order', 'Api\OrderController@index');
    Route::get('order/{id}', 'Api\OrderController@show');
    Route::post('order', 'Api\OrderController@store');
    Route::put('order/{id}', 'Api\OrderController@update');
    Route::delete('order/{id}', 'Api\OrderController@destroy');

    // Order Detail
    Route::get('order-detail', 'Api\OrderDetailController@index');
    Route::get('order-detail/{id}', 'Api\OrderDetailController@show');
    Route::post('order-detail', 'Api\OrderDetailController@store');
    Route::put('order-detail/{id}', 'Api\OrderDetailController@update');
    Route::delete('order-detail/{id}', 'Api\OrderDetailController@destroy');

    // Shopping Bag
    Route::get('shopping-bag', 'Api\ShoppingBagController@index');
    Route::get('shopping-bag/{id}', 'Api\ShoppingBagController@show');
    Route::post('shopping-bag', 'Api\ShoppingBagController@store');
    Route::put('shopping-bag/{id}', 'Api\ShoppingBagController@update');
    Route::delete('shopping-bag/{id}', 'Api\ShoppingBagController@destroy');

    // Contact Us
    Route::get('contact-us', 'Api\ContactUsController@index');
    Route::get('contact-us/{id}', 'Api\ContactUsController@show');
    Route::post('contact-us', 'Api\ContactUsController@store');
    Route::put('contact-us/{id}', 'Api\ContactUsController@update');
    Route::delete('contact-us/{id}', 'Api\ContactUsController@destroy');
});
