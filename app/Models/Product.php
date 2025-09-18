<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'slug',
        'company_id',
        'product_category_id',
        'name_ka',
        'name_en',
        'description_ka',
        'description_en',
        'old_price',
        'price',
        'picture',
        'show_count',
        'status',
    ];

    public function ProductCategory()
    {
        return $this->belongsTo('App\Models\ProductCategory', 'product_category_id');
    }
}
