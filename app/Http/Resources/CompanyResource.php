<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'description_ka'            => $this->description_ka,
            'description_en'            => $this->description_en,
            'category_id'               => $this->category_id,
            'city_id'                   => $this->city_id,
            'address_ka'                => $this->address_ka,
            'address_en'                => $this->address_en,
            'address_latitude'          => $this->address_latitude,
            'address_longitude'         => $this->address_longitude,
            'phone'                     => $this->phone,
            'email'                     => $this->email,
            'soc_facebook'              => $this->soc_facebook,
            'soc_instagram'             => $this->soc_instagram,
            'soc_youtobe'               => $this->soc_youtobe,
            'picture'                   => "https://api.greengo.delivery".$this->picture,
            'show_count'                => $this->show_count,
            'status'                    => $this->status,
        ];
    }
}
