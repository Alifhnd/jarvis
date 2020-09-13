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

Route::group(['prefix' => 'v1'], function () {

     Route::get("/hello" , function (){return "hello world";});
    Route::group(['prefix' => 'product'], function () {
        Route::post("/"  , 'ProductsController@create');
        Route::put("/{id}"  , 'ProductsController@update');
        Route::get("/" , 'ProductsController@index');
        Route::get("/{id}" , 'ProductsController@getProductById');
    });
//     Route::post("/product/add"  , 'ProductsController@create');
//     Route::put("/edit_product/{id}"  , 'ProductsController@update');
//    Route::get("/product/{id?}" , 'ProductsController@read');

});
