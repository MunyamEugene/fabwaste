<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
     /**
     * @OA\Get(
     *   path="/api/stores",
     *   tags={"store"},
     *   security={{"sanctum":{}}},
     *   summary="store",
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
    public function getStores(){
        $stores=Auth::user()->materials()->with('itemNumber')->get();
        return Response::json(['data'=>$stores,'status'=>200],200);
    }
    /**
     * @OA\Get(
     *   path="/api/store/show/{id}",
     *   tags={"Category"},
     *   summary="store details",
     *   security={{"sanctum":{}}},
     * @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="storeId",
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
    public function show($id){
        $store=Store::findOrFail($id);
        return Response::json(['data'=>$store->with('history'),'status'=>200]);
    }

    /**
     * @OA\Put(
     *   path="/api/store/update/{id}",
     *   tags={"store"},
     *   summary="Update store",
     *   security={{"sanctum":{}}},
     * @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="storeId",
     *      @OA\Schema(
     *           type="integer"
     *      ),
     *   ),
     *   @OA\RequestBody(
     *  @OA\JsonContent(
     *    type="object", 
     *    @OA\Property(property="how_many", type="integer"),
     * 
     * ),
     * ),
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
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
    public function update(Request $request,$id){
        $request->validate(['how_many'=>'required|numeric']);
        $store = Store::findOrFail($id);
        $newNumber = $request->input('how_many');
        if (($newNumber + $store->how_many) >= 0) {
            $store->how_many = ($store->how_many + $newNumber);
            $store->save();
            return Response::json(['message' => 'updated successfully', 'status' => 201], 200);
        }
        return Response::json(['message' => 'you entered wrong numbers', 'status' =>400], 400);
    }

    /**
     * @OA\Post(
     *   path="/api/store/create",
     *   tags={"store"},
     *   summary="create store",
     *  security={{"sanctum":{}}},
     *   @OA\RequestBody(
     *  @OA\JsonContent(
     *    type="object", 
     *    @OA\Property(property="how_many", type="integer"),
     * ),
     * ),
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
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
    public function create(Request $request){
        $request->validate(['how_many' => 'required|numeric']);
        $store = new Store();
        $store->name=$request->input('how_many');
        $store->save();
        return Response::json(['message'=>'created successfully','status'=>201],200);
    }

    /**
     * @OA\Delete(
     *   path="/api/store/delete/{id}",
     *   tags={"store"},
     *   summary="delete store",
     *   security={{"sanctum":{}}},
     * @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="storeId",
     *      @OA\Schema(
     *           type="integer"
     *      ),
     *   ),
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
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

    public function delete($id){
        $store=Store::find($id);
        $store->delete();
        return Response::json(['message'=>'deleted successfully'],200);
    }
}
