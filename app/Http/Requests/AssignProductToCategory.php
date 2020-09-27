<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignProductToCategory extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'category_id' => 'required|exists:categories,id',
        ];
    }


    /**
     * @inheritDoc
     */
    public function messages()
    {
        return [
            "product_id.required" => "Please insert product_id",
            "category_id.required" => "Please insert category_id",
        ];
    }
}
