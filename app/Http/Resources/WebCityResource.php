<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WebCityResource extends JsonResource
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
            'picture'                   => $this->picture,
            'show_count'                => $this->show_count,
        ];
    }
}
