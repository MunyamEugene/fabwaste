<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UserCategoryController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/choose/category/{id}",
     *   tags={"users"},
     *   summary="choose category",
     *   security={{"sanctum":{}}},
     *   @OA\Parameter(
     *      name="categoryId",
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
    public function chooseCategory($categoryId)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->categories()->attach($categoryId);
        return Response::json(['user' => $user->with('categories')->first(), 'status' => 200], 200);
    }

    /**
     * @OA\Put(
     *   path="/api/change/category/{id}",
     *   tags={"users"},
     *   summary="change category",
     *   security={{"sanctum":{}}},
     *   @OA\Parameter(
     *      name="categoryId",
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
    public function changeCategory($categoryId)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->categories()->sync($categoryId);
        return Response::json(['user' => $user->with('categories')->first(), 'status' => 200], 200);
    }

    public function removeCategory($categoryId)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->categories()->detach($categoryId);
        return Response::json(['user' => $user->with('categories')->first(), 'status' => 200], 200);
    }
}
