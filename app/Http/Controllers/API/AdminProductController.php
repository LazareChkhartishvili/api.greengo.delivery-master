<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\API\StafiloController as StafiloController;
use App\Models\Product;
use Validator;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Auth;

class AdminProductController extends StafiloController
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list($id)
    {
        $Products = Product::where('company_id', $id)->get();

        if (is_null($Products)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(ProductResource::collection($Products), '200');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'product_category_id' => 'required',
            'name_ka' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $Product = new Product;

        $Product->company_id            = $request->company_id;
        $Product->product_category_id   = $request->product_category_id;
        $Product->name_ka               = $request->name_ka;
        $Product->name_en               = $request->name_en;
        $Product->description_ka        = $request->description_ka;
        $Product->description_en        = $request->description_en;
        $Product->old_price             = $request->old_price;
        $Product->price                 = $request->price;
        $Product->show_count            = 0;
        $Product->status                = $request->status;

         //სურათი
         if($request->hasFile('picture'))
         {
             $image = $request->file('picture');
             $path=public_path('/upload/Product/');
             $name=(md5(microtime()).'.'.$image->getClientOriginalExtension());
             $image->move($path,$name);
             $Product->picture=(env('APP_URL').'/upload/Product/'.$name);
         }else{
             $Product->picture                  =(env('APP_URL').'/no-picture.png');
         }
         // სურათი

        // SLUG
        if( Product::whereSlug(Str::slug($request->name_ka))->count() == 0 )
        {
            $Product->slug                                      =Str::slug($request->name_ka);

        }else{
            $Product->slug                                      =Str::slug($request->name_ka.'-'.time());
        }
        // SLUG

        $Product->save();

        return $this->sendResponse(new ProductResource($Product), ['code'=>'201', 'success'=>'Added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Product = Product::find($id);

        if (is_null($Product)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(new ProductResource($Product), '200');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Product $Product)
    {
        $Product = Product::find($id);

        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'product_category_id' => 'required',
            'name_ka' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $Product->company_id            = $request->company_id;
        $Product->product_category_id   = $request->product_category_id;
        $Product->name_ka               = $request->name_ka;
        $Product->name_en               = $request->name_en;
        $Product->description_ka        = $request->description_ka;
        $Product->description_en        = $request->description_en;
        $Product->old_price             = $request->old_price;
        $Product->price                 = $request->price;
        $Product->status                = $request->status;

        if($request->hasFile('picture'))
         {
             $image = $request->file('picture');
             $path=public_path('/upload/Product/');
             $name=(md5(microtime()).'.'.$image->getClientOriginalExtension());
             $image->move($path,$name);
             $Product->picture=(env('APP_URL').'/upload/Product/'.$name);
         }

        $Product->save();

        return $this->sendResponse(new ProductResource($Product), '201');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        $Product = Product::findOrFail($id);
        $Product->delete();

        return $this->sendResponse([], '200');
    }
}
