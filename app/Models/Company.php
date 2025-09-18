<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'companys';

    protected $fillable = [
        'slug',
        'name_ka',
        'name_en',
        'description_ka',
        'description_en',
        'category_id',
        'city_id',
        'address_ka',
        'address_en',
        'address_latitude',
        'address_longitude',
        'phone',
        'email',
        'soc_facebook',
        'soc_instagram',
        'soc_youtobe',
        'picture',
        'show_count',
        'status',
        'sort',
    ];

    public function Category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function City()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }
}
