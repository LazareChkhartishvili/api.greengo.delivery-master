<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;


class WebProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $pictureRaw = $this->picture;
        $picture = null;
        if (!empty($pictureRaw)) {
            $picture = (Str::startsWith($pictureRaw, ['http://', 'https://']))
                ? $pictureRaw
                : "https://api.greengo.delivery".$pictureRaw;
        }

        return [
            'id'                        => $this->id,
            'slug'                      => $this->slug,
            'product_category_slug'     => $this->ProductCategory->slug ?? null,
            'product_category_name_ka'  => $this->ProductCategory->name_ka ?? null,
            'product_category_name_en'  => $this->ProductCategory->name_en ?? null,
            'name_ka'                   => $this->name_ka,
            'name_en'                   => $this->name_en,
            'description_ka'            => $this->description_ka,
            'description_en'            => $this->description_en,
            'picture'                   => $picture,
            'old_price'                 => $this->old_price,
            'price'                     => $this->price,
            'show_count'                => $this->show_count,
            'status'                    => $this->status,
        ];
    }
}
