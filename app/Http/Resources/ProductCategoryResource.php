<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
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
            'name_ka'                   => $this->name_ka,
            'name_en'                   => $this->name_en,
            'description_ka'            => $this->description_ka,
            'description_en'            => $this->description_en,
            'picture'                   => $this->picture,
            'icon'                      => $this->icon,
            'show_count'                => $this->show_count,
            'status'                    => $this->status,
        ];
    }
}
