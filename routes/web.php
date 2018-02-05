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

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/cerrar', 'HomeController@cerrar')->name('cerrar');

Route::get( '/legajo',                 'LegajoController@index')->name('legajo');
Route::get( '/legajo/create',          'LegajoController@create')->name('legajoCreate');
Route::post('/legajo/create',          'LegajoController@store')->name('legajoStore');
Route::get( '/legajo/{codigo}/edit',   'LegajoController@edit')->name('legajoEdit');
Route::post('/legajo/{codigo}/edit',   'LegajoController@update')->name('legajoUpdate');
Route::get( '/legajo/{codigo}/delete', 'LegajoController@delete')->name('legajoDelete');
Route::post('/legajo/{codigo}/delete', 'LegajoController@destroy')->name('legajoDestroy');
