<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_categorys';

    protected $fillable = [
        'slug',
        'company_id',
        'name_ka',
        'name_en',
        'icon',
        'picture',
        'show_count',
        'status',
        'sort',
    ];
}
