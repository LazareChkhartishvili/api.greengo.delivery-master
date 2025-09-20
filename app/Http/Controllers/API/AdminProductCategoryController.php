<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\API\StafiloController as StafiloController;
use App\Models\ProductCategory;
use Validator;
use App\Http\Resources\ProductCategoryResource;
use Illuminate\Support\Facades\Auth;

class AdminProductCategoryController extends StafiloController
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
        $ProductCategorys = ProductCategory::where('company_id', $id)->get();

        if (is_null($ProductCategorys)) {
            return $this->sendError('ProductCategory not found.');
        }

        return $this->sendResponse(ProductCategoryResource::collection($ProductCategorys), '200');
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
            'name_ka' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $ProductCategory = new ProductCategory;

        $ProductCategory->company_id            = $request->company_id;
        $ProductCategory->name_ka               = $request->name_ka;
        $ProductCategory->name_en               = $request->name_en;
        $ProductCategory->icon                  = $request->icon;
        $ProductCategory->show_count            = 0;
        $ProductCategory->status                = $request->status;

        //სურათი
        if($request->hasFile('picture'))
        {
            $image = $request->file('picture');
            $path=public_path('/upload/ProductCategory/');
            $name=(md5(microtime()).'.'.$image->getClientOriginalExtension());
            $image->move($path,$name);
            $ProductCategory->picture=(env('APP_URL').'/upload/ProductCategory/'.$name);
        }else{
            $ProductCategory->picture                  =(env('APP_URL').'/no-picture.png');
        }
        // სურათი

        // SLUG
        if( ProductCategory::whereSlug(Str::slug($request->name_ka))->count() == 0 )
        {
            $ProductCategory->slug                                      =Str::slug($request->name_ka);

        }else{
            $ProductCategory->slug                                      =Str::slug($request->name_ka.'-'.time());
        }
        // SLUG

        $ProductCategory->save();

        return $this->sendResponse(new ProductCategoryResource($ProductCategory), ['code'=>'201', 'success'=>'Added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ProductCategory = ProductCategory::find($id);

        if (is_null($ProductCategory)) {
            return $this->sendError('ProductCategory not found.');
        }

        return $this->sendResponse(new ProductCategoryResource($ProductCategory), '200');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, ProductCategory $ProductCategory)
    {
        $ProductCategory = ProductCategory::find($id);

        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'name_ka' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $ProductCategory->company_id            = $request->company_id;
        $ProductCategory->name_ka               = $request->name_ka;
        $ProductCategory->name_en               = $request->name_en;
        $ProductCategory->icon                  = $request->icon;
        $ProductCategory->status                = $request->status;

        if($request->hasFile('picture'))
        {
            $image = $request->file('picture');
            $path=public_path('/upload/ProductCategory/');
            $name=(md5(microtime()).'.'.$image->getClientOriginalExtension());
            $image->move($path,$name);
            $ProductCategory->picture=(env('APP_URL').'/upload/ProductCategory/'.$name);
        }

        $ProductCategory->save();

        return $this->sendResponse(new ProductCategoryResource($ProductCategory), '201');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        $ProductCategory = ProductCategory::findOrFail($id);
        $ProductCategory->delete();

        return $this->sendResponse([], '200');
    }

    public function sortUpdate(Request $request)
    {
        $sortData = $request->input('sorts');

        foreach ($sortData as $item) {
            $ProductCategory = ProductCategory::find($item['id']); // ვეძებთ ჩანაწერს

            if ($ProductCategory) {
                $ProductCategory->sort = $item['sort'];
                $ProductCategory->save();
            }
        }

        return response()->json(['code' => '201']);
    }
}
