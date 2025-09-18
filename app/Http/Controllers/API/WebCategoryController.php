<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\StafiloController as StafiloController;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Company;
use App\Http\Resources\WebCompanyResource;

class WebCategoryController extends StafiloController
{
    public function show(string $category_slug)
    {
        $Category = Category::where('slug', $category_slug)->first();

        if (is_null($Category)) {
            return $this->sendError('Category not found.');
        }

        $Companys = Company::where('category_id', $Category->id)
            ->where('status', true)
            ->orderBy('sort', 'asc')
            ->get();

        return $this->sendResponse(WebCompanyResource::collection($Companys), '200');
    }
}



