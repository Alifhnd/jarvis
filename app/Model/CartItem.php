<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CartItem
 * @package App\Model
 *
 * @property string cart_id
 * @property int product_id
 * @property int quantity
 * @property int total_price
 */
class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'total_price'
    ];

    public $incrementing = false;

    /**
     * get cart relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }


    /**
     * get product relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne(Product::class);
    }


    /**
     * find cartItem with cart id and product id
     *
     * @param string $cart_id
     * @param int $product_id
     *
     * @return mixed
     */
    public function findCartItem(string $cart_id, int $product_id)
    {
        return $this->where(['cart_id' => $cart_id, 'product_id' => $product_id])->first();
    }
}
