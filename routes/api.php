<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/logs','LogController',[
    'except'=>['edit','show','store']
]);

Route::post('/logs','LogController@store');
