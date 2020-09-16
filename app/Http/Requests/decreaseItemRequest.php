<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class decreaseItemRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "product_id" => "required"
        ];
    }
}
