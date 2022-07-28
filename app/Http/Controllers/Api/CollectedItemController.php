<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CollectedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CollectedItemController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/items",
     *   tags={"Items"},
     *   summary="Get All Items belongs to you",
     *   security={{"sanctum":{}}},
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
    public function GetItems()
    {
        $items = CollectedItem::where('user_id',Auth::user()->id)->with('history')->get();
        return Response::json(['data' => $items, 'status' => 200], 200);
    }

    /**
     * @OA\Get(
     *   path="/api/items/show/{id}",
     *   tags={"Items"},
     *   summary="Get Items details",
     *   security={{"sanctum":{}}},
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      ),
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
    public function show($id)
    {
        $items = CollectedItem::findOrFail($id);
        return Response::json(['data' => $items, 'status' => 200]);
    }
    /**
     * @OA\Put(
     *   path="/api/items/update/{id}",
     *   tags={"Items"},
     *   summary="Update items",
     *   security={{"sanctum":{}}},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      ),
     *   ),
     * @OA\RequestBody(
     *  @OA\JsonContent(
     *    type="object", 
     *    @OA\Property(property="name", type="string"),
     *    @OA\Property(property="quantity", type="integer"),
     * 
     * ),
     * ),
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
    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required', 'quantity'=> 'required|numeric']);
        $items = CollectedItem::findOrFail($id);
        $quantity=$request->input('quantity');
        if(($quantity+$items->quantity)>=0){
            $items->collected_items_name = $request->input('name');
            $items->quantity = ($items->quantity + $request->input('quantity'));
            $items->save();
            return Response::json(['message' => 'updated successfully', 'status' => 200], 200);
        }
        return Response::json(['message' => 'you entered wrong numbers', 'status' => ($quantity - $items->quantity) < 0], 400);
        
    }

    /**
     * @OA\Post(
     *   path="/api/items/create/{categoryId}",
     *   tags={"Items"},
     *   summary="Add items",
     *   security={{"sanctum":{}}},
     * @OA\Parameter(
     *      name="categoryId",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      ),
     *   ),
     *   @OA\RequestBody(
     *  @OA\JsonContent(
     *    type="object", 
     *    @OA\Property(property="name", type="string"),
     *    @OA\Property(property="quantity", type="integer"),
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
    public function create(Request $request,$categoryId)
    {
        $request->validate(['name' => 'required', 'quantity' => 'required|numeric']);
        $items = new CollectedItem();
        $items->collected_items_name = $request->input('name');
        $items->quantity = $request->input('quantity');
        $items->user_id=Auth::user()->id;
        $items->category_id= $categoryId;
        $items->save();
        return Response::json(['message' => 'created successfully', 'status' => 200], 200);
    }

    /**
     * @OA\Delete(
     *   path="/api/items/delete/{id}",
     *   tags={"Items"},
     *   summary="delete items",
     *   security={{"sanctum":{}}},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
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
    public function delete($id){
        $items=CollectedItem::find($id);
        $items->delete();
        return Response::json(['message'=>'items deleted successfully','status'=>200],200);
    }
}
