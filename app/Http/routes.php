<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', 'PostsController@index');


Route::get('/auth', function (){

    if (Auth::attempt(['email' => 'bedgerotto@gmail.com', 'password' => 1233456]))
    {
        return "Oi";
    }
    return "Falhou";
});

Route::get('/auth/login', 'Auth\AuthController@getLogin');

Route::get('/auth/logout', function(){
    Auth::logout();
});

Route::group(['preffix' => 'admin', 'middleware' => 'auth'], function(){
    Route::get('admin', ['as' => 'admin.index', 'uses' => 'PostsAdminController@index']);
    Route::group(['prefix' => 'posts'], function (){
        Route::get('create', ['as' => 'admin.posts.create', 'uses' => 'PostsAdminController@create']);
        Route::post('store', ['as' => 'admin.posts.store', 'uses' => 'PostsAdminController@store']);
        Route::get('edit/{id}', ['as' => 'admin.posts.edit', 'uses' => 'PostsAdminController@edit']);
        Route::put('update/{id}', ['as' => 'admin.posts.update', 'uses' => 'PostsAdminController@update']);
        Route::get('destroy/{id}', ['as' => 'admin.posts.destroy', 'uses' => 'PostsAdminController@destroy']);
    });
});


