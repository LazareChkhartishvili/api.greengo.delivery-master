<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\API\StafiloController as StafiloController;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\Product;
use Validator;
use App\Http\Resources\WebCategoryResource;
use App\Http\Resources\WebCityResource;
use App\Http\Resources\WebCompanyResource;
use App\Http\Resources\WebCompanyShowResource;
use Illuminate\Support\Facades\Auth;

class WebHomeController extends StafiloController
{

    public function categoryList(Request $request)
    {
        $Categorys = Category::where('status', true)->orderBy('sort', 'asc')->get();

        return $this->sendResponse(WebCategoryResource::collection($Categorys), '200');
    }

    public function cityList(Request $request)
    {
        $Citys = City::where('status', true)->get();

        return $this->sendResponse(WebCityResource::collection($Citys), '200');
    }

    public function companyList(Request $request)
    {
        $Companys = Company::where('status', true)->inRandomOrder()->take(10)->orderBy('sort', 'desc')->get();

        return $this->sendResponse(WebCompanyResource::collection($Companys), '200');
    }

    public function productList(Request $request)
    {
        $limit = (int)($request->input('limit', 20));
        $limit = max(1, min($limit, 100));

        $Products = Product::where('status', true)
            ->orderByDesc('id')
            ->take($limit)
            ->get([
                'id',
                'slug',
                'name_ka',
                'name_en',
                'price',
                'old_price',
                'picture',
                'product_category_slug',
            ]);

        return $this->sendResponse($Products, '200');
    }

    public function filter($city_slug, $category_slug)
    {
        $City = City::where('slug', $city_slug)->first();
        $Category = Category::where('slug', $category_slug)->first();

        $Companys = Company::where('category_id', $Category->id)->where('city_id', $City->id)->orderBy('sort', 'asc')->get();

        if (is_null($Companys)) {
            return $this->sendError('Company not found.');
        }

        return $this->sendResponse(WebCompanyResource::collection($Companys), '200');
    }

    public function companyShow($company_slug)
    {
        $Companys = Company::where('slug', $company_slug)->first();

        //Count Route View Start
        $CompanyShow = Company::where('slug', $company_slug)->first();
        $CompanyShow->show_count = $CompanyShow->show_count+1;
        $CompanyShow->save();
        //Count Route View Start

        if (is_null($Companys)) {
            return $this->sendError('Company not found.');
        }

        return $this->sendResponse(new WebCompanyShowResource($Companys), 'Company retrieved successfully.');
    }


    public function search(Request $request)
    {
        $search = $request->input('search');
        $Companys = Company::where('name_ka', 'LIKE', "%{$search}%")
            ->orWhere('name_en', 'LIKE', "%{$search}%")
            ->get();

        if ($Companys->isEmpty()) {
            return $this->sendError('No companies found for the search term.');
        }

        return $this->sendResponse(WebCompanyResource::collection($Companys), '200');
    }

}
