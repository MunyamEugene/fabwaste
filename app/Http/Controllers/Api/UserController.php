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
    public function getUsers(){
        $users=User::with('categories.items.history')->get();
        return Response::json(['users'=>$users,'status'=>200],200);
    }
    public function show($id){
        $user = User::find($id);
        return Response::json(['user' => $user, 'status' => 200], 200);
    }

    public function assignCollector(Request $request){
        $request->validate([
            'manufactures'=>'required',
            'collectorId'=>'required'
        ]);
        
        $collector=User::find($request->input('collectorId'));
        $collector->collectors()->attach($request->input('manufactures'));
        return Response::json(['message'=>'you assigned new manufacture to'. $collector->lname,'status'=>200],200);
    }


    public function unassignCollector(Request $request)
    {
        $request->validate([
            'manufactures' => 'required',
            'collectorId' => 'required'
        ]);

        $collector = User::find($request->input('collectorId'));
        $collector->manufactures()->detach($request->input('manufactures'));
        return Response::json(['message' => 'you unssigned manufacture to' . $collector->lname, 'status' => 200], 200);
    }

    public function searchCollector($location){
        $result=User::where('iscollector',true)->where('location','like','%'.$location.'%')->get();
        return Response::json(['result'=>$result,'status'=>200],200);
    }


    public function myManufactures(){
        if(Auth::user()->iscollector==true){
            $manufactures=User::with('manufactures')->find(Auth::user()->id);
            return Response::json(['manufactures'=>$manufactures['manufactures']],200);
        }
        return[];
    }

    public function myCollectors(){

        if (Auth::user()->ismanufacture == true) {
            $collectors = User::with('collectors.items.history')->find(Auth::user()->id);
            return Response::json(['collectors' => $collectors['collectors']], 200);
        }
        return [];
    }
    
    public function delete($id){
        $user=User::find($id);
        $user->delete();
        return Response::json(['message'=>'user deleted successfully','status'=>'200'],200);
    }
    
}
