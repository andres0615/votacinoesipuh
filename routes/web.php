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

/*Route::get('/', function () {
    //return view('welcome');
    return view('index');
});*/


Route::group(['middleware' => ['auth']], function(){
  Route::group(["prefix" => "admin", "as" => "admin."], function(){

    Route::resource('persona', 'PersonaController');

    Route::post('persona/destroyMass', [
        'as' => 'persona.destroyMass',
        'uses' => 'PersonaController@destroyMass'
    ]);

    Route::resource('tipopersona', 'TipoPersonaController');

    Route::post('tipopersona/destroyMass', [
        'as' => 'tipopersona.destroyMass',
        'uses' => 'TipoPersonaController@destroyMass'
    ]);

    Route::resource('eleccion', 'EleccionController');

    Route::post('eleccion/destroyMass', [
        'as' => 'eleccion.destroyMass',
        'uses' => 'EleccionController@destroyMass'
    ]);

  });

  Route::get('/profile', ["as" => "profile", function(){
    return view('admin.persona.menu');
  }]);

  //Route::get('/', ["as" => "inicio",'uses' => 'VotacionController@index']);
  Route::get('/', ["as" => "inicio",'uses' => 'VotacionController@index']);
  Route::get('/uieleccion/{eleccion_codigo}', ["as" => "uieleccion",'uses' => 'VotacionController@eleccion']);

  //Route::resource('eleccion', 'VotacionController');

});
Auth::routes();

Route::get('/home', 'HomeController@index');
