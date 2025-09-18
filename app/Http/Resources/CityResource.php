<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'name_ka'                   => $this->name_ka,
            'name_en'                   => $this->name_en,
            'picture'                   => "https://api.greengo.delivery".$this->picture,
            'show_count'                => $this->show_count,
            'status'                    => $this->status,
        ];
    }
}
