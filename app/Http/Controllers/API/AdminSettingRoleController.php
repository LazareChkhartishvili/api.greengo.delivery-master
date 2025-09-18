<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\API\StafiloController as StafiloController;
use App\Models\UserRole;
use Validator;
use App\Http\Resources\UserRoleResource;
use Illuminate\Support\Facades\Auth;

class AdminSettingRoleController extends StafiloController
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
        $UserRoles = UserRole::get();

        return $this->sendResponse(UserRoleResource::collection($UserRoles), '200');
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
            'name' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $UserRole = new UserRole;

        $UserRole->name            = $request->name;
        $UserRole->code            = $request->code;
        $UserRole->color           = $request->color;

        $UserRole->save();

        return $this->sendResponse(new UserRoleResource($UserRole), ['code'=>'201', 'success'=>'Added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $UserRole = UserRole::find($id);

        if (is_null($UserRole)) {
            return $this->sendError('UserRole not found.');
        }

        return $this->sendResponse(new UserRoleResource($UserRole), '200');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, UserRole $UserRole)
    {
        $UserRole = UserRole::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $UserRole->name            = $request->name;
        $UserRole->code            = $request->code;
        $UserRole->color           = $request->color;

        $UserRole->save();

        return $this->sendResponse(new UserRoleResource($UserRole), '201');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        $UserRole = UserRole::findOrFail($id);
        $UserRole->delete();

        return $this->sendResponse([], '200');
    }
}
