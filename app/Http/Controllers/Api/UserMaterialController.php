<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UserMaterialController extends Controller
{

    /**
     * @OA\Post(
     *   path="/api/choose/material/{id}",
     *   tags={"material"},
     *   summary="choose material you will collect",
     *   security={{"sanctum":{}}},
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="materialId",
     *      @OA\Schema(
     *           type="integer"
     *      ),
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *      description="Unauthenticated",
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function chooseMaterialToCollect($id)
    {
        
        $user = User::findOrFail(Auth::user()->id);
        $user->materials()->attach($id);
        return Response::json(['data' =>$user->with('materials'), 'status' => 201], 200);
    }

    /**
     * @OA\Put(
     *   path="/api/change/material/{id}",
     *   tags={"material"},
     *   summary="switch to new material you will collect by changing the old one",
     *   security={{"sanctum":{}}},
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="materialId",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      ),
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *      description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function changeMaterialToCollect($id)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->materials()->sync($id);
        return Response::json(['user' =>$user->with('materials') , 'status' => 201], 200);
    }

    public function removeMaterial($id)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->materials()->detach($id);
        return Response::json(['message' => 'deleted successfully', 'status' => 200], 200);
    }
}
