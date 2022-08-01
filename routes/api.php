<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\NewPasswordController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CollectedItemController;
use App\Http\Controllers\Api\UserCategoryController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum','cors'])->group(function () {

//category
Route::get('categories', [CategoryController::class, 'GetCategories']);
Route::get('category/show/{id}', [CategoryController::class, 'edit'])->middleware('admin');
Route::put('category/update/{id}', [CategoryController::class, 'update'])->middleware('admin');
Route::post('category/create', [CategoryController::class, 'create'])->middleware('admin');
Route::delete('category/delete/{id}', [CategoryController::class, 'delete'])->middleware('admin');


//items
Route::get('items', [CollectedItemController::class, 'GetItems'])->middleware('collector');
Route::get('items/show/{id}', [CollectedItemController::class, 'show'])->middleware('collector');
Route::put('items/update/{id}', [CollectedItemController::class, 'update'])->middleware('collector');
Route::post('items/create/{categoryId}', [CollectedItemController::class, 'create'])->middleware('collector');
Route::delete('items/delete/{id}', [CollectedItemController::class, 'delete'])->middleware('collector');

//user
Route::get('users', [UserController::class, 'getUsers'])->middleware('admin');
Route::get('user/show/{id}', [UserController::class, 'show'])->middleware('admin');
Route::post('assign/collector/{collectorId}/{manufactureId}', [UserController::class, 'assignCollector'])->middleware('admin');
Route::put('unassign/collector/{collectorId}/{manufactureId}', [UserController::class, 'unassignCollector'])->middleware('admin');
Route::get('search/collector/{location}', [UserController::class, 'searchCollector']);
Route::delete('user/delete/{id}', [UserController::class, 'delete'])->middleware('admin');
Route::get('mycollectors', [UserController::class, 'myCollectors']);
Route::get('mymanufactures', [UserController::class, 'myManufactures']);
Route::get('manufactures',[UserController::class, 'manufactures'])->middleware('admin');
Route::get('collectors',[UserController::class,'collectors'])->middleware('admin');
Route::put('approve/{id}',[UserController::class,'approve'])->middleware('admin');

//UserCategory
Route::post('choose/category/{categoryId}', [UserCategoryController::class, 'chooseCategory']);
Route::put('change/category/{categoryId}', [UserCategoryController::class, 'changeCategory']);
Route::post('delete/category/{categoryId}', [UserCategoryController::class, 'removeCategory']);

//logout
Route::post('logout', [AuthController::class, 'logout']);
}
);

//Authentication
Route::post('collector/register', [AuthController::class, 'registerCollectore']);
Route::post('manufacture/register', [AuthController::class, 'registerManufacture']);
Route::post('login', [AuthController::class, 'login'])->middleware('login');
Route::post('forgot', [NewPasswordController::class, 'forgotPassword']);
Route::post('reset', [NewPasswordController::class, 'reset']);

