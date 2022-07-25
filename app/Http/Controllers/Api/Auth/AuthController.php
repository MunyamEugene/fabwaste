<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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

    public function registerManufacture(Request $request)
    {

        $manufacture = $request->validate([
            'phone' => 'required|string|size:10',
            'email' => 'required|string|email|unique:users',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'manufactureName' => 'required',
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


 
}
