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
            'price'=>$this->price,
            'discount'=>$this->discount,
            'category_id' => $this->category_id,
            'title'=> $this->trans->title ?? '',
            'description'=>$this->trans->description ?? '',
        ];
    }
}
