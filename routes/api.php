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

Route::group(['prefix'=>'v1'], function(){

    Route::group(['as'=>'auth.','prefix'=>'auth'], function(){

        Route::post('/login',[
            'uses'=>'Auth\AuthBasic@login',
        ]);

        Route::post('/register',[
            'uses'=>'Auth\AuthBasic@register',
        ]);

    });

    Route::group(['as'=>'quote.','prefix'=>'quote'], function(){

        route::get('/',[
            'uses' => 'Api\Random@quote',
            'as' => 'chuck',
        ]);
        
    });

    Route::group(['middleware'=>'auth:api','as'=>'transaction.','prefix'=>'transaction'], function(){

        route::post('/',[
            'uses' => 'Api\Transaction@transaction',
            'as' => 'transaction',
        ]);
        
    });

    Route::group(['middleware'=>'auth:api','as'=>'price.','prefix'=>'price'], function(){

        route::post('/upload',[
            'uses' => 'Api\History@upload',
            'as' => 'upload',
        ]);

        route::post('/low-high',[
            'uses' => 'Api\History@lowhigh',
            'as' => 'lowhigh',
        ]);

        route::post('/history',[
            'uses' => 'Api\History@history',
            'as' => 'history',
        ]);
        
    });

});