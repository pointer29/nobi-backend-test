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

Route::post('/login',[
    'uses'=>'Auth\AuthBasic@login',
]);

Route::post('/register',[
    'uses'=>'Auth\AuthBasic@register',
]);

Route::group(['as'=>'random.','prefix'=>'random'], function(){

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