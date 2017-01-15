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

Route::get('/', function () {
    return view('welcome');
});


//It's a simple project, so using static routes

Route::get('rooms/details/{room_types}/{dates}', 'RoomsController@get_details');
Route::get('rooms/all', 'RoomsController@get_all_rooms');

Route::post('rooms/price', 'RoomsController@post_price');
Route::post('rooms/inventory', 'RoomsController@post_inventory');


Auth::routes();

Route::get('/home', 'HomeController@index');
