<?php

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', 'MainController@index')->name('main.index');

Route::get('/user/{user}', 'UserController@show')->name('user.show');

Route::get('/user/{user}/items', 'UserController@items')->name('user.items');

Route::get('/item/{item}', 'ItemController@show')->name('item.show');

Route::get('/category/{category}', 'CategoryController@index');
Route::get('/subcategories/{id}', 'CategoryController@getsubcategories');

Route::get('/sorted', 'MainController@sortedbylikes');

Route::get('/item/{item}/comments', 'ItemCommentController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/my-favorites', 'HomeController@showFavorites');

Route::group(['middleware' => ['auth']], function () {
    Route::post('/item/create', [
        'as' => 'item.create',
        'uses' => 'ItemController@create',
    ]);

Route::post('/item/{item}/destroy', 'ItemController@destroy');
Route::post('/item/{item}/restore', 'ItemController@restore');    

Route::post('/item/{item}/favorite', 'ItemFavoriteController@store');
Route::post('/item/{item}/unfavorite', 'ItemFavoriteController@destroy');

Route::post('/item/{item}/like', 'ItemLikeController@store');
Route::post('/item/{item}/unlike', 'ItemLikeController@destroy');

Route::post('/item/{item}/comments', 'ItemCommentController@create');
Route::delete('/item/{item}/comments/{comment}', 'ItemCommentController@delete');

Route::get('/countfav/{item}', 'ItemFavoriteController@getCount');

});

Route::get('/login/{service}', 'Auth\SocialLoginController@redirect');
Route::get('/login/{service}/callback', 'Auth\SocialLoginController@callback');

Route::get('/activate/token/{token}', 'Auth\ActivationController@activate')->name('auth.activate');
Route::get('/activate/resend', 'Auth\ActivationController@resend')->name('auth.activate.resend');
