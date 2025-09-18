<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categorys';

    protected $fillable = [
        'slug',
        'name_ka',
        'name_en',
        'description_ka',
        'description_en',
        'picture',
        'svg',
        'show_count',
        'status',
        'sort',
    ];


}
