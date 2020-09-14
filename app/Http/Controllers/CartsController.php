<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowCartRequest;
use App\Http\Resources\CartItemCollection;
use App\Model\Cart;
use Illuminate\Http\Request;

class CartsController extends Controller
{
    /**
     * store a newly created Cart in storage and return the data to the user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $cart = Cart::create([
            "id" => uniqid($this->getRandomString()),
            "key"=> uniqid($this->getRandomString())
        ]);

        return response()->json([
            'Message'  => 'A new cart have been created for you!',
            'cartToken'=> $cart->key,
            'cartKey'  => $cart->key
        ],201);
    }


    /**
     * display the specified Cart
     *
     * @param ShowCartRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ShowCartRequest $request)
    {
        $model = new Cart();
        $cart_key = $request->cartKey;

        $cart = $model->findCartByKey($cart_key);
        if (!$cart){
            return response()->json([
                'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
            ], 400);
        }
        return response()->json([
            'cart' => $cart->id,
            'Items in Cart' => new CartItemCollection($cart->items),
        ], 200);
    }


    /**
     * generate random string
     *
     * @param int $length
     *
     * @return string
     */
    private function getRandomString(int $length=5):string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters_length = strlen($characters);
        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, $characters_length - 1)];
        }
        return $random_string;
    }
}
