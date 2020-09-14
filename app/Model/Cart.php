<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "id",
        "key"
    ];

    public $incrementing = false;


    /**
     * One-to-Many relation cart items
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }


    /**
     * find cart by cart key
     *
     * @param string $key
     *
     * @return mixed
     */
    public function findCartByKey(string $key)
    {
       return $this->where("key" , $key)->first();
    }
}
