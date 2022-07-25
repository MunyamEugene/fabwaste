<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CollectedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CollectedItemController extends Controller
{
    public function GetItems()
    {
        $items = CollectedItem::all();
        return Response::json(['data' => $items, 'status' => 200], 200);
    }
    public function edit($id)
    {
        $items = CollectedItem::findOrFail($id);
        return Response::json(['data' => $items, 'status' => 200]);
    }
    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required', 'quantity'=> 'required|numeric']);
        $items = CollectedItem::findOrFail($id);
        $quantity=$request->input('quantity');
        if(($quantity+$items->quantity)>=0){
            $items->collected_items_name = $request->input('name');
            $items->quantity = ($items->quantity + $request->input('quantity'));
            $items->save();
            return Response::json(['message' => 'updated successfully', 'status' => 200], 200);
        }
        return Response::json(['message' => 'you entered wrong numbers', 'status' => ($quantity - $items->quantity) < 0], 400);
        
    }

    public function create(Request $request,$categoryId)
    {
        $request->validate(['name' => 'required', 'quantity' => 'required|numeric']);
        $items = new CollectedItem();
        $items->collected_items_name = $request->input('name');
        $items->quantity = $request->input('quantity');
        $items->user_id=Auth::user()->id;
        $items->category_id= $categoryId;
        $items->save();
        return Response::json(['message' => 'created successfully', 'status' => 200], 200);
    }

    public function delete($id){
        $items=CollectedItem::find($id);
        $items->delete();
        return Response::json(['message'=>'items deleted successfully','status'=>200],200);
    }
}
