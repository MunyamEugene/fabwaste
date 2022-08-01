<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;


class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/categories",
     *   tags={"Category"},
     *   security={{"sanctum":{}}},
     *   summary="All categories",
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
    public function GetCategories(){
        $categories=Category::all();
        return Response::json(['data'=>$categories,'status'=>200],200);
    }
    /**
     * @OA\Get(
     *   path="/api/category/show/{id}",
     *   tags={"Category"},
     *   summary="category details",
     *   security={{"sanctum":{}}},
     * @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      ),
     *   ),
     *  @OA\RequestBody(
     *  @OA\JsonContent(
     *    type="object", 
     *    @OA\Property(property="name", type="string"),
     *    @OA\Property(property="unit", type="string"),
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
    public function edit($id){
        $category=Category::findOrFail($id);
        return Response::json(['data'=>$category,'status'=>200]);
    }

    /**
     * @OA\Put(
     *   path="/api/category/update/{id}",
     *   tags={"Category"},
     *   summary="Update category",
     *   security={{"sanctum":{}}},
     * @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="categoryId",
     *      @OA\Schema(
     *           type="integer"
     *      ),
     *   ),
     *   @OA\RequestBody(
     *  @OA\JsonContent(
     *    type="object", 
     *    @OA\Property(property="name", type="string"),
     *    @OA\Property(property="unit", type="string"),
     *    @OA\Property(property="description", type="string"),
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
        $request->validate(['name'=>'required','unit'=>'required', 'description'=>'required']);
        $category = Category::findOrFail($id);
        $category->name=$request->input('name');
        $category->countingUnit = $request->input('unit');
        $category->description=$request->input('description');
        $category->save();
        return Response::json(['message'=>'updated successfully','status'=>200],200);
    }

    /**
     * @OA\Post(
     *   path="/api/category/create",
     *   tags={"Category"},
     *   summary="create category",
     *  security={{"sanctum":{}}},
     *   @OA\RequestBody(
     *  @OA\JsonContent(
     *    type="object", 
     *    @OA\Property(property="name", type="string"),
     *    @OA\Property(property="unit", type="string"),
     *    @OA\Property(property="description", type="string"),
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
    public function create(Request $request){
        $request->validate(['name' => 'required','unit'=>'required','description'=>'required']);
        $category = new Category();
        $category->name=$request->input('name');
        $category->countingUnit=$request->input('unit');
        $category->description=$request->input('description');
        $category->save();
        return Response::json(['message'=>'created successfully','status'=>200],200);
    }

    /**
     * @OA\Delete(
     *   path="/api/category/delete/{id}",
     *   tags={"Category"},
     *   summary="delete category",
     *   security={{"sanctum":{}}},
     * @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="categoryId",
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
        $category=Category::find($id);
        $category->delete();
        return Response::json(['message'=>'deleted successfully'],200);
    }
}
