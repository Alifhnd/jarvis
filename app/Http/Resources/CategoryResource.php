<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            'parent_id' => $this->parent_id,
            "locale" => $this -> locale,
            "children" => CategoryResource::collection($this->whenLoaded('children')),
            "product" => ProductsResource::collection($this->whenLoaded('products'))
        ];
    }
}
