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
Route::get('/home',                          'HomeController@index')->name('home');
Route::get('/cerrar',                        'HomeController@cerrar')->name('cerrar');

Route::get( '/legajo',                       'LegajoController@index')->name('legajo');
Route::get( '/legajo/create',                'LegajoController@create')->name('legajoCreate');
Route::post('/legajo/create',                'LegajoController@store')->name('legajoStore');
Route::get( '/legajo/{codigo}/edit',         'LegajoController@edit')->name('legajoEdit');
Route::post('/legajo/{codigo}/edit',         'LegajoController@update')->name('legajoUpdate');
Route::get( '/legajo/{codigo}/delete',       'LegajoController@delete')->name('legajoDelete');
Route::post('/legajo/{codigo}/delete',       'LegajoController@destroy')->name('legajoDestroy');

Route::get('/cuota/{codigo}/cuenta',         'CuotaController@cuenta')->name('cuotaCuenta');
Route::get('/cuota/{codigo}/pdfcuenta',      'CuotaController@pdfcuenta')->name('cuotaPdfCuenta');
Route::get('/cuota/{codigo}/mailcuenta',     'CuotaController@mailcuenta')->name('cuotaMailCuenta');
Route::get('/cuota/{codigo}/create',         'CuotaController@create')->name('cuotaCreate');
Route::post('/cuota/{codigo}/create',        'CuotaController@store')->name('cuotaStore');
Route::get('/cuota/{codigo}/delete',         'CuotaController@delete')->name('cuotaDelete');
Route::post('/cuota/{codigo}/delete',        'CuotaController@destroy')->name('cuotaDestroy');
Route::get('/cuota/{codigo}/cambiaremail',   'CuotaController@cambiarEmail')->name('cuotaCambiarEmail');
Route::post('/cuota/{codigo}/cambiaremail',  'CuotaController@cambiarEmailStore')->name('cuotaCambiarEmailStore');

Route::get( '/pago',                         'PagoController@index')->name('pago');
Route::get( '/pago/{codigo}/create',         'PagoController@create')->name('pagoCreate');
Route::post('/pago/{codigo}/create',         'PagoController@store')->name('pagoStore');
Route::get( '/pago/{dia}/{mes}/{anio}/pdfListadoPago', 'PagoController@pdfListadoPago')->name('pagoListadoPdf');
Route::get( '/pago/{codigo}/delete',         'PagoController@delete')->name('pagoDelete');
Route::post( '/pago/{codigo}/delete',        'PagoController@destroy')->name('pagoDestroy');

Route::get( '/ajuste',                       'AjusteController@index')->name('ajuste');
Route::get( '/ajuste/{codigo}/create',       'AjusteController@create')->name('ajusteCreate');
Route::post('/ajuste/{codigo}/create',       'AjusteController@store')->name('ajusteStore');
Route::get( '/ajuste/{codigo}/delete',       'AjusteController@delete')->name('ajusteDelete');
Route::post('/ajuste/{codigo}/delete',       'AjusteController@destroy')->name('ajusteDestroy');

Route::get( '/liquidacion',                  'LiquidacionController@index')->name('liquidacion');
Route::get( '/liquidacion/create',           'LiquidacionController@create')->name('liquidacionCreate');
Route::post('/liquidacion/create',           'LiquidacionController@store')->name('liquidacionStore');
Route::get( '/liquidacion/{codigo}/delete',  'LiquidacionController@delete')->name('liquidacionDelete');
Route::post('/liquidacion/{codigo}/delete',  'LiquidacionController@destroy')->name('liquidacionDestroy');
Route::get( '/liquidacion/{codigo}/cuenta',  'LiquidacionController@cuenta')->name('liquidacionCuenta');

Route::get( '/liquidacion/{codigo}/pagoexpress',  'LiquidacionController@createpagoexpress')->name('liquidacioncreatepagoexpress');
Route::post('/liquidacion/{codigo}/pagoexpress',  'LiquidacionController@storepagoexpress')->name('liquidacionstorepagoexpress');

Route::get( '/asistencia',                   'AsistenciaController@index')->name('asistencia');
Route::get( '/asistencia/create',            'AsistenciaController@create')->name('asistenciaCreate');
Route::post('/asistencia/create',            'AsistenciaController@store')->name('asistenciaStore');

Route::get( '/asistencia/{codigo}/edit',     'AsistenciaController@edit')->name('asistenciaEdit');
Route::post('/asistencia/{codigo}/edit',     'AsistenciaController@update')->name('asistenciaUpdate');

Route::get( '/asistencia/{codigo}/delete',   'AsistenciaController@delete')->name('asistenciaDelete');
Route::post('/asistencia/{codigo}/delete',   'AsistenciaController@destroy')->name('asistenciaDestroy');

Route::get( '/asistencia/{codigo}/add',     'AsistenciaController@addasistencia');
Route::post('/asistencia/{codigo}/add',     'AsistenciaController@storeasistencia');
Route::get( '/asistencia/{codigo}/del',     'AsistenciaController@deleteasistencia');
Route::post('/asistencia/{codigo}/del',     'AsistenciaController@destroyasistencia');
