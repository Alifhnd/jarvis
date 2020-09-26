<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    public $collects = 'App\Http\Resources\ProductResource';

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'locale' => $this->locale,
            'title'=> $this->title,
            'price'=>$this->price,
            'description'=>$this->description,
            'discount'=>$this->discount
        ];
    }
}
