<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\API\StafiloController as StafiloController;
use App\Models\UserStatus;
use Validator;
use App\Http\Resources\UserStatusResource;
use Illuminate\Support\Facades\Auth;

class AdminSettingStatusController extends StafiloController
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $UserStatuss = UserStatus::get();

        return $this->sendResponse(UserStatusResource::collection($UserStatuss), '200');
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

        $UserStatus = new UserStatus;

        $UserStatus->name            = $request->name;
        $UserStatus->code            = $request->code;
        $UserStatus->color           = $request->color;

        $UserStatus->save();

        return $this->sendResponse(new UserStatusResource($UserStatus), ['code'=>'201', 'success'=>'Added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $UserStatus = UserStatus::find($id);

        if (is_null($UserStatus)) {
            return $this->sendError('UserStatus not found.');
        }

        return $this->sendResponse(new UserStatusResource($UserStatus), '200');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, UserStatus $UserStatus)
    {
        $UserStatus = UserStatus::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $UserStatus->name            = $request->name;
        $UserStatus->code            = $request->code;
        $UserStatus->color           = $request->color;

        $UserStatus->save();

        return $this->sendResponse(new UserStatusResource($UserStatus), '201');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        $UserStatus = UserStatus::findOrFail($id);
        $UserStatus->delete();

        return $this->sendResponse([], '200');
    }
}
