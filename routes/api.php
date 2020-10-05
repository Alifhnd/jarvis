<?php

use Illuminate\Http\Request;

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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1' , "middleware" => 'setLocale'], function () {

    Route::get("/hello" , function (){return "hello world";});
    Route::group(['prefix' => 'product'], function () {
        Route::post("/"  , 'ProductsController@create');
        Route::put("/{id}"  , 'ProductsController@update');
        Route::get("/" , 'ProductsController@index');
        Route::get("/{id}" , 'ProductsController@getProductById');
        Route::post("/assign" , 'ProductsController@assignProductToCategory');
    });
    Route::group(["prefix" => "cart"], function (){
        Route::get("/show" , "CartsController@show");
        Route::post("/" , "CartsController@create");
        Route::post('/{id}', 'CartsController@addProduct');
        Route::post('/increase/{id}', 'CartsController@increase');
        Route::post('/decrease/{id}', 'CartsController@decrease');
        Route::delete('/item/{id}', 'CartsController@removeItem');
    });
    Route::group(["prefix" => "category"], function (){
        Route::post("/" , "CategoryController@create");
        Route::get("/" , "CategoryController@show");
    });


    Route::group(["prefix" => "admin" , "middleware" => ['assign.guard:admins']] , function () {
            Route::post("/login", "Admin\AuthController@login");
            Route::post("/register", "Admin\AuthController@register");
            Route::post("/logout", "Admin\AuthController@logout");
            Route::get("/me", "Admin\AuthController@me");
    });
});
