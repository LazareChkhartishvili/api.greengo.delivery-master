<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id'                        => $this->id,
            'company_id'                => $this->company_id,
            'product_category_id'       => $this->product_category_id,
            'name_ka'                   => $this->name_ka,
            'name_en'                   => $this->name_en,
            'description_ka'            => $this->description_ka,
            'description_en'            => $this->description_en,
            'picture'                   => "https://api.greengo.delivery".$this->picture,
            'old_price'                 => $this->old_price,
            'price'                     => $this->price,
            'show_count'                => $this->show_count,
            'status'                    => $this->status,
        ];
    }
}
