<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/videos', 'VideosController@getAll');
Route::get('/videos/latest', 'VideosController@latest');
Route::post('/videos', 'VideosController@create');
Route::get('/videos/{id}', 'VideosController@view');
Route::post('/videos/{id}/labels', 'VideosController@addLabel');
Route::get('/videos/{id}/labels', 'VideosController@getLabels');
Route::post('/videos/{id}/votes', 'VideosController@addVote');
Route::get('/videos/{id}/votes', 'VideosController@getVotes');

Route::get('/labels/{label}/videos', 'LabelsController@view');
Route::post('/labels', 'LabelsController@create');