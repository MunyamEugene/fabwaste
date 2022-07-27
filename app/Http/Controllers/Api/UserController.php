<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CollectedItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/users",
     *   tags={"users"},
     *   summary="All users",
     *   @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *           @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *    @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *    @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *    @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *    @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *
     * ),
     */
    public function getUsers(){
        $users=User::with('categories.items.history')->get();
        return Response::json(['users'=>$users,'status'=>200],200);
    }

    /**
     * @OA\Get(
     *   path="/api/user/show/{id}",
     *   tags={"users"},
     *   summary="user Detail",
     *   security={{"bearer_token":{}}},
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
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
        $user = User::find($id);
        return Response::json(['user' => $user, 'status' => 200], 200);
    }

    /**
     * @OA\Get(
     *   path="/api/collectors",
     *   tags={"users"},
     *   summary="All collectors",
     *   @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *           @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *    @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *    @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *    @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *    @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *
     * ),
     */
    public function collectors(){
        $collectors=User::where('iscollector',true)->get();
        return Response::json(['collectors'=>$collectors,'status'=>200]);
    }

    /**
     * @OA\Get(
     *   path="/api/manufactures",
     *   tags={"users"},
     *   summary="All manufactures",
     *   @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *           @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *    @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *    @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *    @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *    @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *
     * ),
     */
    public function manufactures(){
        $manufactures = User::where('ismanufacture', true)->get();
        return Response::json(['manufactures' => $manufactures, 'status' => 200]);
    }

    /**
     * @OA\post(
     *   path="/api/assign/collector/{collectorId}/{manufactureId}",
     *   tags={"users"},
     *   summary="assign collector to manufacture",
     *   @OA\Parameter(
     *      name="collectorId",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      ),
     *   ),
     * @OA\Parameter(
     *      name="manufactureId",
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
    public function assignCollector($collectorId, $manufactureId){
     
        $collector=User::find($collectorId);
        $collector->collectors()->attach($manufactureId);
        return Response::json(['message'=>'you assigned new manufacture to'. $collector->lname,'status'=>200],200);
    }



    /**
     * @OA\Put(
     *   path="/api/assign/collector/{collectorId}/{manufactureId}",
     *   tags={"users"},
     *   summary="unassign collector to manufacture",
     *   @OA\Parameter(
     *      name="collectorId",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      ),
     *   ),
     * @OA\Parameter(
     *      name="manufactureId",
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
    public function unassignCollector($collectorId,$manufactureId)
    {
        $collector = User::find($collectorId);
        $collector->manufactures()->detach($manufactureId);
        return Response::json(['message' => 'you unssigned manufacture to' . $collector->lname, 'status' => 200], 200);
    }
    /**
     * @OA\Get(
     *   path="/api/assign/user/search/{location}",
     *   tags={"users"},
     *   summary="search collector",
     *   @OA\Parameter(
     *      name="location",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
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

    public function searchCollector($location){
        $location=strtolower($location);
        $result=User::where('iscollector',true)->where('location','like','%'.$location.'%')->get();
        return Response::json(['result'=>$result,'status'=>200],200);
    }

    /**
     * @OA\Get(
     *   path="/api/mymanufactures",
     *   tags={"users"},
     *   summary="collector's manufactures",
     *    @OA\Parameter(
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
    public function myManufactures(){
        if(Auth::user()->iscollector==true){
            $manufactures=User::with('manufactures')->find(Auth::user()->id);
            return Response::json(['manufactures'=>$manufactures['manufactures']],200);
        }
        return[];
    }

    /**
     * @OA\Get(
     *   path="/api/mycollectors",
     *   tags={"users"},
     *   summary="manufacture's collectors",
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
    public function myCollectors(){

        if (Auth::user()->ismanufacture == true) {
            $collectors = User::with('collectors.items.history')->find(Auth::user()->id);
            return Response::json(['collectors' => $collectors['collectors']], 200);
        }
        return [];
    }

    /**
     * @OA\Put(
     *   path="/api/approve/{id}",
     *   tags={"users"},
     *   summary="approve user account",
     *   @OA\Parameter(
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
    public function approve($id){
        $collector=User::find($id);
        if($collector->isapproved){
            $collector->isapproved=0;
            $collector->save();
            return Response::json(['message' => $collector->fname . '\'s accunt approved', 'status' => 201]);
        }else{
        $collector->isapproved=1;
        $collector->save();
        return Response::json(['message'=>$collector->fname. '\'s accunt disapproved','status'=>201]);
        }
    }
    /**
     * @OA\Delete(
     *   path="/api/user/delete/{id}",
     *   tags={"users"},
     *   summary="delete user",
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
        $user=User::find($id);
        $user->delete();
        return Response::json(['message'=>'user deleted successfully','status'=>'200'],200);
    }
    
}
