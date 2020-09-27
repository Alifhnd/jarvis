<?php

namespace App\Http\Requests;

use App\Model\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class CreateCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $locales = Config::get('app.locales');
        $ids = Category::all()->pluck('id')->toArray();
        return [
            "title"=>"required",
            "locale"=>"required|in:". implode(',', $locales),
            "parent_id" => "integer|in:" . implode(',', $ids),
        ];
    }


    /**
     * @inheritDoc
     */
    public function messages()
    {
        return [
            "title.required" => "Please insert title",
            "locale.in" => "Please insert valid locale",
            "parent_id.in" => "Please insert valid Parent_id",
            "parent_id.integer" => "parent_id must be integer"
        ];
    }
}
