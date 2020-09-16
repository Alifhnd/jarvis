<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductToCartRequest;
use App\Http\Requests\decreaseItemRequest;
use App\Http\Requests\IncreaseItemRequest;
use App\Http\Requests\ShowCartRequest;
use App\Http\Resources\CartItemCollection;
use App\Model\Cart;
use App\Model\CartItem;
use App\Model\Product;
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
            "id" => uniqid($this->getRandomString(4)),
            "key" => uniqid($this->getRandomString())
        ]);
        dump($cart);

        return response()->json([
            'Message' => 'A new cart have been created for you!',
            'cartToken' => $cart->id,
            'cartKey' => $cart->key
        ], 201);
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

        $model = $model->findCartByKey($cart_key);

        if (!$model) {
            return response()->json([
                'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
            ], 400);
        }
        return response()->json([
            'cart' => $model->id,
            'Items in Cart' => new CartItemCollection($model->items),
        ], 200);
    }


    /**
     * add product to cart
     *
     * @param AddProductToCartRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addProduct(AddProductToCartRequest $request)
    {
        $cartKey = $request->cartKey;
        $product_id = $request->product_id;
        $quantity = $request->quantity;

        /**@var Cart $cart*/
        $cart = Cart::where("key" , $cartKey)->first();
        if (!$cart) {
            return response()->json([
                'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
            ], 400);
        }
        $product = new Product();
        $product = $product->findProductById($product_id);
        if (!$product){
            return response()->json([
                'message' => 'The Product you\'re trying to add does not exist.',
            ], 404);
        }

        $cart_item = new CartItem();
        $cart_item = $cart_item->findCartItem($cart->getKey() , $product_id);

        if ($cart_item) {
            $new_quantity = $quantity + $cart_item->quantity;
            $total_price = $this->calculateTotalPrice($product_id , $new_quantity);
            $discount =  $total_price['discount'];
            CartItem::where(['cart_id' => $cart->id, 'product_id' => $product_id])->update(['quantity' => $new_quantity , 'total_price' => $total_price['total_price'] ,'total_discount'=>$discount]);
        } else {
            $total_price = $this->calculateTotalPrice($product_id , $quantity);
            CartItem::create(['cart_id' => $cart->id, 'product_id' => $product_id, 'quantity' => $quantity , 'total_price' => $total_price['total_price'] , 'total_discount'=>$total_price['discount']]);
        }

        $cart->updateCartInfo();

        return response()->json(['message' => 'The Cart was updated with the given product information successfully'], 200);
    }


    /**
     * Increase an item of cart
     *
     * @param IncreaseItemRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function increase(IncreaseItemRequest $request)
    {
        /**@var Cart $cart*/
        $cart = Cart::find($request->id);
        if (!$cart){
            return response()->json(['message' => 'The cart not fount.'],404);
        }
        $item = new CartItem();
        $cart_item = $item->findCartItem($cart->getKey() , $request->product_id);
        $total = $this->calculateTotalPrice($request->product_id , 1);

        $quantity = $cart_item->quantity + 1;
        $total_price = $cart_item->total_price + $total['total_price'];
        $total_discount = $cart_item->total_discount + $total['discount'];

        $cart_item->where(['cart_id' => $cart->id, 'product_id' => $request->product_id])->update([
            'quantity' => $quantity,
            'total_price' => $total_price,
            'total_discount'=>$total_discount
        ]);
        $cart->updateCartInfo();

        return response()->json(['message' => 'Product added!'],201);
    }


    /**
     * Decrease an item of cart
     *
     * @param decreaseItemRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function decrease(decreaseItemRequest $request)
    {
        /**@var Cart $cart*/
        $cart = Cart::find($request->id);
        if (!$cart){
            return response()->json(['message' => 'The cart not fount.'],404);
        }
        $item = new CartItem();
        $cart_item = $item->findCartItem($cart->getKey() , $request->product_id);
        $total = $this->calculateTotalPrice($request->product_id , 1);

        $quantity = $cart_item->quantity - 1;
        $total_price = $cart_item->total_price - $total['total_price'];
        $total_discount = $cart_item->total_discount - $total['discount'];

        $cart_item->where(['cart_id' => $cart->id, 'product_id' => $request->product_id])->update([
            'quantity' => $quantity,
            'total_price' => $total_price,
            'total_discount'=>$total_discount
        ]);

        return response()->json(['message' => 'Product decreased!'],201);
    }


    /**
     * generate random string
     *
     * @param int $length
     *
     * @return string
     */
    private function getRandomString(int $length = 5): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters_length = strlen($characters);
        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, $characters_length - 1)];
        }
        return $random_string;
    }


    /**
     * calculate the total price
     *
     * @param int $product_id
     * @param int $quantity
     *
     * @return array
     */
    private function calculateTotalPrice(int $product_id, int $quantity): array
    {
        $model = new Product();
        $product = $model->findProductById($product_id);
        $price = $product->price;
        $discount = $product->discount * $quantity;
        $total_amount = ($price - $discount) * $quantity;

        return ["total_price" => $total_amount , "discount" => $discount];
    }
}
