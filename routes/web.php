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
    return view('auth.login');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

//Institucion
Route::get('/institucion', 'InstitucionController@index');
Route::post('/institucion/registrar', 'InstitucionController@store');
Route::put('/institucion/actualizar', 'InstitucionController@update');

//Tipos de institucion
Route::get('/tipo', 'TipoController@index');
Route::post('/tipo/registrar', 'TipoController@store');
Route::put('/tipo/actualizar', 'TipoController@update');
Route::delete('/tipo/eliminar/{id}', 'TipoController@destroy');
Route::get('/tipo/selectTipo', 'TipoController@selectTipo');

//Rama
Route::get('/rama', 'RamaController@index');
Route::post('/rama/registrar', 'RamaController@store');
Route::put('/rama/actualizar', 'RamaController@update');
Route::delete('/rama/eliminar/{id}', 'RamaController@destroy');
Route::get('/rama/selectRama', 'RamaController@selectRama');

//Estado
Route::get('/estado', 'EstadoController@index');
Route::post('/estado/registrar', 'EstadoController@store');
Route::put('/estado/actualizar', 'EstadoController@update');
Route::delete('/estado/eliminar/{id}', 'EstadoController@destroy');
Route::get('/estado/selectEstado', 'EstadoController@selectEstado');

//Cargo
Route::get('/cargo', 'CargoController@index');
Route::post('/cargo/registrar', 'CargoController@store');
Route::put('/cargo/actualizar', 'CargoController@update');
Route::delete('/cargo/eliminar/{id}', 'CargoController@destroy');
Route::get('/cargo/selectCargo', 'CargoController@selectCargo');

//Empleado
Route::get('/empleado', 'EmpleadoController@index');
Route::post('/empleado/registrar', 'EmpleadoController@store');
Route::put('/empleado/actualizar', 'EmpleadoController@update');
Route::delete('/empleado/eliminar/{id}', 'EmpleadoController@destroy');
Route::get('/empleado/selectEmpleado', 'EmpleadoController@selectEmpleado');

//Ausencia
Route::get('/ausencia', 'AusenciaController@index');
Route::post('/ausencia/registrar', 'AusenciaController@store');
Route::put('/ausencia/actualizar', 'AusenciaController@update');
Route::delete('/ausencia/eliminar/{id}', 'AusenciaController@destroy');

//Objetivo
Route::get('/objetivo', 'ObjetivoController@index');
Route::post('/objetivo/registrar', 'ObjetivoController@store');
Route::put('/objetivo/actualizar', 'ObjetivoController@update');
Route::delete('/objetivo/eliminar/{id}', 'ObjetivoController@destroy');
Route::get('/objetivo/obtenerCabecera', 'ObjetivoController@obtenerCabecera');
Route::get('/objetivo/obtenerDetalles', 'ObjetivoController@obtenerDetalles');
Route::get('/objetivo/selectObjetivo', 'ObjetivoController@selectObjetivo');
Route::get('/objetivo/selectObjetivoEmpleado/{objetivo_id}', 'ObjetivoController@selectObjetivoEmpleado');
Route::post('/objetivo/registrarObjetivoEmpleado', 'ObjetivoController@registrarObjetivoEmpleado');

//Curso
Route::get('/curso', 'CursoController@index');
Route::post('/curso/registrar', 'CursoController@store');
Route::put('/curso/actualizar', 'CursoController@update');
Route::delete('/curso/eliminar/{id}', 'CursoController@destroy');
Route::get('/curso/obtenerCabecera', 'CursoController@obtenerCabecera');
Route::get('/curso/obtenerDetalles', 'CursoController@obtenerDetalles');
Route::get('/curso/selectCurso', 'CursoController@selectCurso');
Route::get('/curso/selectCursoEmpleado/{curso_id}', 'CursoController@selectCursoEmpleado');
Route::post('/curso/registrarCursoEmpleado', 'CursoController@registrarCursoEmpleado');

//Cuestionario
Route::get('/cuestionario', 'CuestionarioController@index');
Route::post('/cuestionario/registrar', 'CuestionarioController@store');
Route::put('/cuestionario/actualizar', 'CuestionarioController@update');
Route::delete('/cuestionario/eliminar/{id}', 'CuestionarioController@destroy');
Route::get('/cuestionario/obtenerCabecera', 'CuestionarioController@obtenerCabecera');
Route::get('/cuestionario/obtenerDetalles', 'CuestionarioController@obtenerDetalles');

//Usuario
Route::get('/user', 'UserController@index');
Route::post('/user/registrar', 'UserController@store');
Route::put('/user/actualizar', 'UserController@update');
Auth::routes();
