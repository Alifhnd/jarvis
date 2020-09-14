<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title"=>"required",
            "price"=>"required|integer",
            "quantity"=>"required|integer",
            "discount"=>"integer",
            "description"=>"string"
        ];
    }


    /**
     * @inheritDoc
     */
    public function messages()
    {
        return [
            "title.required"=>"Please insert title",
            "price.required"=>"Please insert price",
            "price.integer"=>"price must be integer",
            "quantity.required"=>"Please insert quantity",
            "quantity.integer"=>"quantity must be integer",
            "discount.integer"=>"discount must be integer",

        ];
    }
}
