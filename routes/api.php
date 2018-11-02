<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/logs','LogController',[
    'except'=>['edit','show','store']
]);

Route::post('/logs','LogController@store');

Route::resource('/domains','DomainController',[
    'except'=>['edit','show','store']
]);

Route::post('/domains','DomainController@addNewDomainLog');

Route::get('/domain-logs/{id}','DomainController@getLogsDomain');

Route::delete('/logs/{id}','LogController@destroy');

Route::patch('/logs/{id}','LogController@update');

