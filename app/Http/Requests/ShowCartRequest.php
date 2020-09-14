<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ShowCartRequest
 * @package App\Http\Requests
 *
 * @property string cartKey
 */
class ShowCartRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "cartKey" => "required|string"
        ];
    }


    /**
     * @inheritDoc
     */
    public function messages()
    {
        return [
            "cartKey.required" => "Please insert cartKey.",
            "cartKey.string"   => "The cartKey must be string."
        ];
    }
}
