<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::prefix('/transactions')->middleware('auht:api')->group(function(){
//     Route::get('/', 'API\TransactionController@index');
//     Route::post('/', )
// })

// Route::get('/transactions', 'API\TransactionController@index')->middleware('auth:api');
//Route::apiResource('/transactions', 'API\TransactionController' )->middleware('auth:api', 'auth');
Route::prefix('/transactions/')->middleware('auth:api')->group(function(){

    Route::get('/filter', 'API\TransactionController@filter');
    Route::get('/balance', 'API\TransactionController@balance');

});
Route::apiResource('/transactions', 'API\TransactionController' )->middleware('auth:api', 'auth');