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


Route::get('/', ["as" => "inicio",
    function () {
      //return view('welcome');
      return view('admin.main');
      //return view('index');
    }]);


//Route::group(['middleware' => ['auth']], function(){
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

    Route::post('elecciona/destroyMass', [
        'as' => 'eleccion.destroyMass',
        'uses' => 'EleccionController@destroyMass'
    ]);

  });
/*});
Auth::routes();

Route::get('/home', 'HomeController@index');*/
