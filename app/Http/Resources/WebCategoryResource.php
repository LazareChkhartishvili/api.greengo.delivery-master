<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WebCategoryResource extends JsonResource
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
            'slug'                      => $this->slug,
            'name_ka'                   => $this->name_ka,
            'name_en'                   => $this->name_en,
            'description_ka'            => $this->description_ka,
            'description_en'            => $this->description_en,
            'picture'                   => $this->picture,
            'svg'                       => $this->svg,
            'show_count'                => $this->show_count,
        ];
    }
}
