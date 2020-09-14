<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AddProductToCartRequest
 * @package App\Http\Requests
 *
 * @property string cartKey
 * @property int product_id
 * @property int quantity
 */
class AddProductToCartRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cartKey' => 'required',
            'product_id' => 'required',
            'quantity' => 'required|numeric',
        ];
    }


    /**
     * @inheritDoc
     */
    public function messages()
    {
        return [
            "cartKey.required" => "Please insert the cartKey.",
            "product_id.required" => "Please insert the product id.",
            "quantity.required" => "Please insert the quantity.",
            "quantity.numeric" => "The quantity must be numeric."
        ];
    }
}
