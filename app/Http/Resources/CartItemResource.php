<?php

namespace App\Http\Resources;

use App\Model\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $product = Product::find($this->product_id);

        return [
            'productID'  => $this->product_id,
            'discount'   => $product->discount,
            'price'      => $product->price,
            'Name'       => $product->name,
            'Quantity'   => $this->quantity,
            'TotalPrice' => $this->total_price
        ];
    }
}
