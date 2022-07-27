<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/collector/register",
     *   tags={"Auth"},
     *   summary="Collector register",
     *   @OA\RequestBody(
     *  @OA\JsonContent(
     *    type="object", 
     *    @OA\Property(property="fname", type="string"),
     *    @OA\Property(property="lnam", type="string"),
     *  @OA\Property(property="email", type="string"),
     *    @OA\Property(property="password", type="string"),
     *  @OA\Property(property="password_confirmation", type="string"),
     *    @OA\Property(property="location", type="string"),
     *  @OA\Property(property="phone", type="string"),
     *    @OA\Property(property="district", type="string"),
     *  @OA\Property(property="city", type="string"),
     *    @OA\Property(property="streetNumber", type="string"),
     *  @OA\Property(property="iscollector", type="boolean", example="true"),

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
    public function registerCollectore(Request $request)
    {

        $collector = $request->validate([
            'phone' => 'required|string|size:10',
            'email' => 'required|string|email|unique:users',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'fname'=>'required',
            'lname' => 'required',
            'location'=>'required',
            'district' => 'required',
            'city' => 'required',
            'streetNumber' => 'required',
            'iscollector'=>'required',
        ]);

        $user = User::create([
            'fname' => $collector['fname'],
            'lname' => $collector['lname'],
            'location' => $collector['location'],
            'phone' => $collector['phone'],
            'district' => $collector['district'],
            'city' => $collector['city'],
            'iscollector'=>$collector['iscollector'],
            'streetNumber' => $collector['streetNumber'],
            'email' => $collector['email'],
            'password' => Hash::make($collector['password']),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user'=>$user
        ]);
    }

    /**
     * @OA\Post(
     *   path="/api/manufacture/register",
     *   tags={"Auth"},
     *   summary="Manufacture register",
     *   @OA\RequestBody(
     *  @OA\JsonContent(
     *    type="object", 
     *    @OA\Property(property="manufactureName", type="string"),
     *  @OA\Property(property="email", type="string"),
     *  @OA\Property(property="password", type="string"),
     *  @OA\Property(property="password_confirmation", type="string"),
     *  @OA\Property(property="location", type="string"),
     *  @OA\Property(property="pobox", type="string"),
     *  @OA\Property(property="phone", type="string"),
     *  @OA\Property(property="district", type="string"),
     *  @OA\Property(property="city", type="string"),
     *  @OA\Property(property="streetNumber", type="string"),
     *  @OA\Property(property="ismanufacture", type="boolean",example="true"),
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
    public function registerManufacture(Request $request)
    {

        $manufacture = $request->validate([
            'manufactureName' => 'required',
            'phone' => 'required|string|size:10',
            'email' => 'required|string|email|unique:users',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'location'=>'required',
            'pobox'=>'required',
            'district' => 'required',
            'city' => 'required',
            'streetNumber' => 'required',
            'ismanufacture' => 'required',
        ]);

        $user = User::create([
            'manufactureName' => $manufacture['manufactureName'],
            'phone' => $manufacture['phone'],
            'pobox' => $manufacture['pobox'],
            'district' => $manufacture['district'],
            'city' => $manufacture['city'],
            'location'=>$manufacture['location'],
            'ismanufacture' => $manufacture['ismanufacture'],
            'streetNumber' => $manufacture['streetNumber'],
            'email' => $manufacture['email'],
            'password' => Hash::make($manufacture['password']),
        
        ]);

        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    /**
     * @OA\Post(
     *   path="/api/login",
     *   tags={"Auth"},
     *   summary="Login",
     *   @OA\RequestBody(
     *  @OA\JsonContent(
     *    type="object", 
     *  @OA\Property(property="email", type="string",example="sam@gmail.com"),
     *  @OA\Property(property="password", type="string",example="password"),
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
    public function login(Request $request)
    {

        $crendentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'min:6|required',
        ]);
        if (!Auth::attempt($crendentials)) {
            return response()->json([
                'message' => 'Login information is invalid.'
            ], 401);
        }

        $user = User::where('email', $crendentials['email'])->firstOrFail();
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    /**
     * @OA\Post(
     *   path="/api/logout",
     *   tags={"Auth"},
     *   summary="Logout",
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
    public function logout(Request $request){
        Auth::user()->tokens()->delete();
        return [
            'message' => 'user logged out'
        ];
    }

}
