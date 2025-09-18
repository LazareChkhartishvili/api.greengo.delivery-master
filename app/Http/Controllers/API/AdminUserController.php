<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\API\StafiloController as StafiloController;
use App\Models\User;
use Validator;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends StafiloController
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
        $Users = User::get();

        return $this->sendResponse(UserResource::collection($Users), '200');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $User = User::find($id);

        if (is_null($User)) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse(new UserResource($User), '200');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, User $User)
    {
        $User = User::find($id);

        $validator = Validator::make($request->all(), [
            // 'name_ka' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $User->name_ka               = $request->name_ka;
        $User->name_en               = $request->name_en;
        $User->status                = $request->status;

        $User->save();

        return $this->sendResponse(new UserResource($User), '201');
    }


}
