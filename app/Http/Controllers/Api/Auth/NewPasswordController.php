<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class NewPasswordController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/forgot",
     *   tags={"Auth"},
     *   summary="Forgot password",
     *   @OA\RequestBody(
     *  @OA\JsonContent(
     *    type="object", 
     *  @OA\Property(property="email", type="string",example="sam@gmail.com"),
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
    public function forgotPassword(Request $request){
        $request->validate(['email'=>'required|email']);
        $status=Password::sendResetLink($request->only('email'));
        if($status==Password::RESET_LINK_SENT){
            return ['status'=>__($status)];
        }
        throw ValidationException::withMessages([
            'email'=>[trans($status)]
        ]);
    }

    /**
     * @OA\Post(
     *   path="/api/reset",
     *   tags={"Auth"},
     *   summary="Reset password",
     *   @OA\RequestBody(
     *  @OA\JsonContent(
     *    type="object", 
     *  @OA\Property(property="email", type="string",example="sam@gmail.com"),
     *  @OA\Property(property="password", type="string",example="password"),
     *  @OA\Property(property="password-confirmation", type="string"),
     * @OA\Property(property="token"),
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
    public function reset(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if($status==Password::PASSWORD_RESET){
            return Response::json(['message'=>'password reset successfully']);
        }
        return Response::json(['message'=>__($status)],500);
    }
}
