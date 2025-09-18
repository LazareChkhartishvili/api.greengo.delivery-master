<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\API\StafiloController as StafiloController;
use App\Models\City;
use Validator;
use App\Http\Resources\CityResource;
use Illuminate\Support\Facades\Auth;

class AdminSettingCityController extends StafiloController
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
        $Citys = City::get();

        return $this->sendResponse(CityResource::collection($Citys), '200');
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

        $City = new City;

        $City->name_ka               = $request->name_ka;
        $City->name_en               = $request->name_en;
        $City->show_count            = 0;
        $City->status                = $request->status;

        //სურათი
        if($request->hasFile('picture'))
        {
            $image = $request->file('picture');
            $path=public_path('/upload/City/');
            $name=(md5(microtime()).'.'.$image->getClientOriginalExtension());
            $image->move($path,$name);
            $City->picture=('/upload/City/'.$name);
        }else{
            $City->picture                  ='/no-picture.png';
        }
        // სურათი

        // SLUG
        if( City::whereSlug(Str::slug($request->name_ka))->count() == 0 )
        {
            $City->slug                                      =Str::slug($request->name_ka);

        }else{
            $City->slug                                      =Str::slug($request->name_ka.'-'.time());
        }
        // SLUG

        $City->save();

        return $this->sendResponse(new CityResource($City), ['code'=>'201', 'success'=>'Added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $City = City::find($id);

        if (is_null($City)) {
            return $this->sendError('City not found.');
        }

        return $this->sendResponse(new CityResource($City), '200');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, City $City)
    {
        $City = City::find($id);

        $validator = Validator::make($request->all(), [
            // 'name_ka' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $City->name_ka               = $request->name_ka;
        $City->name_en               = $request->name_en;
        $City->status                = $request->status;

        if($request->hasFile('picture'))
        {
            $image = $request->file('picture');
            $path=public_path('/upload/City/');
            $name=(md5(microtime()).'.'.$image->getClientOriginalExtension());
            $image->move($path,$name);
            $City->picture=('/upload/City/'.$name);
        }

        $City->save();

        return $this->sendResponse(new CityResource($City), '201');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        $City = City::findOrFail($id);
        $City->delete();

        return $this->sendResponse([], '200');
    }
}
