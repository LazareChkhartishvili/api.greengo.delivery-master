<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

use App\Models\Product;

class WebProductCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $Products = Product::where('product_category_id', $this->id)->get();

        $pictureRaw = $this->picture;
        $picture = null;
        if (!empty($pictureRaw)) {
            $picture = (Str::startsWith($pictureRaw, ['http://', 'https://']))
                ? $pictureRaw
                : config('app.url').$pictureRaw;
        }

        return [
            // 'id'                        => $this->id,
            // 'company_id'                => $this->company_id,
            'slug'                      => $this->slug,
            'name_ka'                   => $this->name_ka,
            'name_en'                   => $this->name_en,
            'description_ka'            => $this->description_ka,
            'description_en'            => $this->description_en,
            'picture'                   => $picture,
            'icon'                      => $this->icon,
            'show_count'                => $this->show_count,
            'products'                  => WebProductResource::collection($Products),
            'status'                    => $this->status,
        ];
    }
}
