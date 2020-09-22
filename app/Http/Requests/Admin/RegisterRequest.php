<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>"string",
            "email"=> "required|email|unique:admins,email",
            "mobile" => "min:11|max:11|unique:admins,mobile",
            "password"=>"required",
            "password_confirm"=>"required|same:password"

        ];
    }

    /**
     * @inheritDoc
     */
    public function messages()
    {
        return[
            "name.string" => "The name must be string.",
            "email.required"=> "Please insert email.",
            "email.email" => "Please enter the email correctly.",
            "email.unique" => "Email already exists.",
            "mobile.mix" => "Mobile should not be more than 11.",
            "mobile.min" => "Mobile should not be less than 11.",
            "password.required" => "Please insert password.",
            "password_confirm.required" => "Please insert password_confirm.",
            "password_confirm.same" => "Password confirmation must match the password.",
        ];
    }
}
