<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;


class CategoryController extends Controller
{
    public function GetCategories(){
        $categories=Category::all();
        return Response::json(['data'=>$categories,'status'=>200],200);
    }
    public function edit($id){
        $category=Category::findOrFail($id);
        return Response::json(['data'=>$category,'status'=>200]);
    }
    public function update(Request $request,$id){
        $request->validate(['name'=>'required','unit'=>'required']);
        $category = Category::findOrFail($id);
        $category->name=$request->input('name');
        $category->countingUnit = $request->input('unit');
        $category->save();
        return Response::json(['message'=>'updated successfully','status'=>200],200);
    }

    public function create(Request $request){
        $request->validate(['name' => 'required','unit'=>'required']);
        $category = new Category();
        $category->name=$request->input('name');
        $category->countingUnit=$request->input('unit');
        $category->save();
        return Response::json(['message'=>'created successfully','status'=>200],200);
    }

    public function delete($id){
        $category=Category::find($id);
        $category->delete();
        return Response::json(['message'=>'deleted successfully'],200);
    }
}
