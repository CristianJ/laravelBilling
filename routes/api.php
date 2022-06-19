
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

/*Route::middleware('auth:api')->get('user', function (Request $request) {
    return $request->user();
});*/

Route::post('login','UsuariosController@login');

Route::group(['middleware'=>['cors',/*'jwt.auth'*/]],function(){
    // Route::post('login','UsuariosController@login');
     Route::resource('users','UsuariosController');
     Route::resource('ingresos','IngresosController');
     Route::resource('gastos','GastosController');
     Route::resource('categoriasgastos','CategoriasGastosController');
     Route::resource('categoriasingresos','CategoriasIngresosController');
     Route::resource('cuentas','CuentasController');
     Route::resource('bancos','BancosController');
     Route::resource('cingresos','CingresosController');
     Route::resource('cgastos','CgastosController');
     Route::resource('deudas','DeudasController');
     Route::resource('cuotas','CuotasController');
    Route::get('vergasto/{id}','GastosController@vergasto');
    Route::get('veringreso/{id}','IngresosController@veringreso');
    Route::get('verfechaingresos/{id}/{fecha_inicio}/{fecha_fin}/{categoria}','IngresosController@verfechas');
    Route::get('verfechagastos/{id}/{fecha_inicio}/{fecha_fin}/{categoria}','GastosController@verfechas');
    Route::get('verdeuda/{id}','DeudasController@verdeuda');
    Route::get('cuentasusuario/{user_id}/{banco_id}','CuentasController@cuentasusuario');
    Route::get('cgastospaginados/{id}','CuentasController@cgastospaginados');
    Route::get('cingresospaginados/{id}','CuentasController@cingresospaginados');
    Route::get('cuentaid/{user_id}/{cuenta_id}','CuentasController@cuentaid');
    Route::get('cuentabanco/{cuenta_id}','CuentasController@cuentabanco');
    Route::get('cuentaUsuario/{id}','CuentasController@cuentabancoXUsuario');
    Route::get('cuentaBancoUsuario/{user_id}/{banco_id}','CuentasController@getCuentaByBanco');
    Route::get('getCgasto/{id}','CgastosController@getCgasto');
    Route::get('getCingreso/{id}','CingresosController@getCingreso');
    Route::put('deuda_pagada/{id}','DeudasController@deuda_pagada');
    Route::get('getUserData/{id}','UsuariosController@getUserData');



    Route::get('paginar', 'GastosController@paginar');
    Route::get('graficas', 'GastosController@graficas');
    Route::get('userbancos/{id}','UsuariosController@getBankData');
});
