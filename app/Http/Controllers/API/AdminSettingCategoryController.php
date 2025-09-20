<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\API\StafiloController as StafiloController;
use App\Models\Category;
use Validator;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Auth;

class AdminSettingCategoryController extends StafiloController
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
    public function list()
    {
        $Categorys = Category::get();

        return $this->sendResponse(CategoryResource::collection($Categorys), '200');
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
            'name_ka' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $Category = new Category;

        $Category->name_ka               = $request->name_ka;
        $Category->name_en               = $request->name_en;
        $Category->description_ka        = $request->description_ka;
        $Category->description_en        = $request->description_en;
        $Category->svg                   = $request->svg;
        $Category->show_count            = 0;
        $Category->status                = $request->status;

        //სურათი
        if($request->hasFile('picture'))
        {
            $image = $request->file('picture');
            $path=public_path('/upload/Category/');
            $name=(md5(microtime()).'.'.$image->getClientOriginalExtension());
            $image->move($path,$name);
            $Category->picture=(env('APP_URL').'/upload/Category/'.$name);
        }else{
            $Category->picture                  =(env('APP_URL').'/no-picture.png');
        }
        // სურათი

        // SLUG
        if( Category::whereSlug(Str::slug($request->name_ka))->count() == 0 )
        {
            $Category->slug                                      =Str::slug($request->name_ka);

        }else{
            $Category->slug                                      =Str::slug($request->name_ka.'-'.time());
        }
        // SLUG

        $Category->save();

        return $this->sendResponse(new CategoryResource($Category), ['code'=>'201', 'success'=>'Added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Category = Category::find($id);

        if (is_null($Category)) {
            return $this->sendError('Category not found.');
        }

        return $this->sendResponse(new CategoryResource($Category), '200');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Category $Category)
    {
        $Category = Category::find($id);

        $validator = Validator::make($request->all(), [
            'name_ka' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $Category->name_ka               = $request->name_ka;
        $Category->name_en               = $request->name_en;
        $Category->description_ka        = $request->description_ka;
        $Category->description_en        = $request->description_en;
        $Category->svg                   = $request->svg;
        $Category->status                = $request->status;

        if($request->hasFile('picture'))
        {
            $image = $request->file('picture');
            $path=public_path('/upload/Category/');
            $name=(md5(microtime()).'.'.$image->getClientOriginalExtension());
            $image->move($path,$name);
            $Category->picture=('/upload/Category/'.$name);
        }

        $Category->save();

        return $this->sendResponse(new CategoryResource($Category), '201');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        $Category = Category::findOrFail($id);
        $Category->delete();

        return $this->sendResponse([], '200');
    }

    public function sortUpdate(Request $request)
    {
        $sortData = $request->input('sorts');

        foreach ($sortData as $item) {
            $Category = Category::find($item['id']); // ვეძებთ ჩანაწერს

            if ($Category) {
                $Category->sort = $item['sort'];
                $Category->save();
            }
        }

        return response()->json(['code' => '201']);
    }
}
