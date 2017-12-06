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

Route::group(['namespace' => 'Api'], function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/videos', 'VideosController@create');
        Route::post('/videos/{id}/labels', 'VideosController@addLabel');
        Route::post('/votes/video/{id}', 'VotesController@create');
        Route::post('/labels', 'LabelsController@create');
    });

    Route::get('/videos', 'VideosController@getAll');
    Route::get('/videos/latest', 'VideosController@latest');
    Route::get('/videos/{id}', 'VideosController@view');
    Route::get('/videos/{id}/labels', 'VideosController@getLabels');
    Route::get('/votes/video/{id}', 'VotesController@get');
    Route::get('/labels/{label}/videos', 'LabelsController@view');
    Route::get('/labels', 'LabelsController@getAll');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
