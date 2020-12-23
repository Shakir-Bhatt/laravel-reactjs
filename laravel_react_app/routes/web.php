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

// Route::get('/{path}', function () {
//     return view('welcome');
// })->where('path','.*');


Route::get('/','TaskController@index');

Route::post('task/save','TaskController@store');

Route::get('task/edit/{id}','TaskController@edit');

Route::post('task/update/{id}','TaskController@update');

Route::get('task/delete/{id}','TaskController@destroy');


