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

Route::get('/', function () {
    return view('soon');
});

Route::group(['prefix' => 'api/v1', 'namespace' => 'Api\V1', 'middleware' => 'throttle:250'], function () {
    Route::get('/', ['as' => 'api.index', 'uses' => 'IndexController@index']);
    Route::get('search', ['as' => 'api.search', 'uses' => 'ProductController@search']);
});

// Catch any routes not defined and display the homepage
// TODO: Change this to a 404 page
Route::any('{path?}', function () {
    return view('soon');
})->where('path', '.+');
