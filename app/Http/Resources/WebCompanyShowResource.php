<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Product;
use App\Models\ProductCategory;

class WebCompanyShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $Products = Product::where('company_id', $this->id)->get();
        $ProductCategorys = ProductCategory::where('company_id', $this->id)->orderBy('sort', 'asc')->get();

        return [
            'slug'                      => $this->slug,
            'name_ka'                   => $this->name_ka,
            'name_en'                   => $this->name_en,
            'description_ka'            => $this->description_ka,
            'description_en'            => $this->description_en,
            // 'category_id'               => $this->category_id,
            'category_name_ka'          => $this->Category->name_ka ?? null,
            'category_name_en'          => $this->Category->name_en ?? null,
            'category_slug'             => $this->Category->slug ?? null,
            'city_name_ka'              => $this->City->name_ka ?? null,
            'city_name_en'              => $this->City->name_en ?? null,
            'city_slug'                 => $this->City->slug ?? null,
            'address_ka'                => $this->address_ka,
            'address_en'                => $this->address_en,
            'address_latitude'          => $this->address_latitude,
            'address_longitude'         => $this->address_longitude,
            'phone'                     => $this->phone,
            'email'                     => $this->email,
            'soc_facebook'              => $this->soc_facebook,
            'soc_instagram'             => $this->soc_instagram,
            'soc_youtobe'               => $this->soc_youtobe,
            'picture'                   => $this->picture,
            'product_category'          => WebProductCategoryResource::collection($ProductCategorys),
            // 'products'                  => WebProductResource::collection($Products),
            'show_count'                => $this->show_count,
        ];
    }
}
