<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\API\StafiloController as StafiloController;
use App\Models\Company;
use Validator;
use App\Http\Resources\CompanyResource;
use Illuminate\Support\Facades\Auth;

class AdminCompanyController extends StafiloController
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
        $Companys = Company::get();

        return $this->sendResponse(CompanyResource::collection($Companys), '200');
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
            'category_id' => 'required',
            'city_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $Company = new Company;

        $Company->name_ka                       = $request->name_ka;
        $Company->name_en                       = $request->name_en;
        $Company->description_ka                = $request->description_ka;
        $Company->description_en                = $request->description_en;
        $Company->category_id                   = $request->category_id;
        $Company->city_id                       = $request->city_id;
        $Company->address_ka                    = $request->address_ka;
        $Company->address_en                    = $request->address_en;
        $Company->address_latitude              = $request->address_latitude;
        $Company->address_longitude             = $request->address_longitude;
        $Company->phone                         = $request->phone;
        $Company->email                         = $request->email;
        $Company->soc_facebook                  = $request->soc_facebook;
        $Company->soc_instagram                 = $request->soc_instagram;
        $Company->soc_youtobe                   = $request->soc_youtobe;
        $Company->show_count                    = 0;
        $Company->status                        = $request->status;

        //სურათი
        if($request->hasFile('picture'))
        {
            $image = $request->file('picture');
            $path=public_path('/upload/Company/');
            $name=(md5(microtime()).'.'.$image->getClientOriginalExtension());
            $image->move($path,$name);
            $Company->picture=('/upload/Company/'.$name);
        }else{
            $Company->picture                  ='/no-picture.png';
        }
        // სურათი

        // SLUG
        if( Company::whereSlug(Str::slug($request->name_ka))->count() == 0 )
        {
            $Company->slug                                      =Str::slug($request->name_ka);

        }else{
            $Company->slug                                      =Str::slug($request->name_ka.'-'.time());
        }
        // SLUG

        $Company->save();

        return $this->sendResponse(new CompanyResource($Company), ['code'=>'201', 'success'=>'Added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Company = Company::find($id);

        if (is_null($Company)) {
            return $this->sendError('Company not found.');
        }

        return $this->sendResponse(new CompanyResource($Company), '200');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Company $Company)
    {
        $Company = Company::find($id);

        $validator = Validator::make($request->all(), [
            'name_ka' => 'required',
            'category_id' => 'required',
            'city_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $Company->name_ka                       = $request->name_ka;
        $Company->name_en                       = $request->name_en;
        $Company->description_ka                = $request->description_ka;
        $Company->description_en                = $request->description_en;
        $Company->category_id                   = $request->category_id;
        $Company->city_id                       = $request->city_id;
        $Company->address_ka                    = $request->address_ka;
        $Company->address_en                    = $request->address_en;
        $Company->address_latitude              = $request->address_latitude;
        $Company->address_longitude             = $request->address_longitude;
        $Company->phone                         = $request->phone;
        $Company->email                         = $request->email;
        $Company->soc_facebook                  = $request->soc_facebook;
        $Company->soc_instagram                 = $request->soc_instagram;
        $Company->soc_youtobe                   = $request->soc_youtobe;
        $Company->status                        = $request->status;

        if($request->hasFile('picture'))
        {
            $image = $request->file('picture');
            $path=public_path('/upload/Company/');
            $name=(md5(microtime()).'.'.$image->getClientOriginalExtension());
            $image->move($path,$name);
            $Company->picture=('/upload/Company/'.$name);
        }

        $Company->save();

        return $this->sendResponse(new CompanyResource($Company), '201');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        $Company = Company::findOrFail($id);
        $Company->delete();

        return $this->sendResponse([], '200');
    }

    public function sortUpdate(Request $request)
    {
        $sortData = $request->input('sorts');

        foreach ($sortData as $item) {
            $Company = Company::find($item['id']); // ვეძებთ ჩანაწერს

            if ($Company) {
                $Company->sort = $item['sort'];
                $Company->save();
            }
        }

        return response()->json(['code' => '201']);
    }
}
