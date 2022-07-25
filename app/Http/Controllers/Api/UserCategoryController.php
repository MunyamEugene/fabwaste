<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UserCategoryController extends Controller
{
    public function chooseCategory(Request $request){
        $choice = $request->validate([
            'categories' => 'required'
        ]);
        $user= User::findOrFail(Auth::user()->id);
        $user->categories()->attach($choice['categories']);
        return Response::json(['user'=>$user->with('categories')->first(),'status'=>200],200);
    }

    public function changeCategory(Request $request){
        $choice = $request->validate([
            'categories' => 'required'
        ]);
        $user = User::findOrFail(Auth::user()->id);
        $user->categories()->sync($choice['categories']);
        return Response::json(['user' => $user->with('categories')->first(),'status'=>200],200);
    }

    public function removeCategory(Request $request){
        $choice = $request->validate([
            'categories' => 'required'
        ]);
        $user = User::findOrFail(Auth::user()->id);
        $user->categories()->detach($choice['categories']);
        return Response::json(['user' => $user->with('categories')->first(), 'status' => 200], 200);

    }
}
