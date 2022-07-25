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
