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

Route::group(['as'=>'task1.','prefix'=>'task1'], function(){

    Route::post('/login',[
        'uses'=>'Auth\AuthBasic@login',
    ]);

    Route::post('/register',[
        'uses'=>'Auth\AuthBasic@register',
    ]);

});

Route::group(['as'=>'task2.','prefix'=>'task2'], function(){

    route::get('/chuck',[
        'uses' => 'Api\Random@chuck',
        'as' => 'chuck',
    ]);

    route::get('/dog',[
        'uses' => 'Api\Random@dog',
        'as' => 'dog',
    ]);

    route::get('/cat',[
        'uses' => 'Api\Random@cat',
        'as' => 'cat',
    ]);
    
});

Route::group(['middleware'=>'auth:api','as'=>'task3.','prefix'=>'task3'], function(){

    route::post('/transaction',[
        'uses' => 'Api\Transaction@transaction',
        'as' => 'transaction',
    ]);
    
});