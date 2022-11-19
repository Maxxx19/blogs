<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
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

Route::middleware(['auth.basic'])->group(function ($user) {
   
    Route::get('/user', function (Request $request) {
            
        if($request->user()->user_type == 'admin'){
            $data = bcrypt("sdfskjl2j42jkl".rand(1,121450893));
            Cache::put("user_api_data", $data);
            Cookie::forever("user_api_data", $data);
        }
        return response($request->user())->withCookie(Cookie::forever("user_api_data", $data));
    });        
       
        if(Cache::get("user_api_data")){
            if( Cache::get("user_api_data") == Cookie::get("user_api_data")){

            Route::apiResource('articles', ArticleController::class);

            }
        }  
       
});



